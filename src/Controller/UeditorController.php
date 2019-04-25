<?php

namespace Jims\EditorHubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UeditorController extends Controller
{
    protected $CONFIG;

    protected function initConfig()
    {
        /*
        $config_path = $this->get('kernel')->getRootDir(). "/../src/Jims/EditorHubBundle/Resources/public/ueditor/php/";
        #$config_path = $this->container->getParameter('kernel.root_dir') . '/../web/bundles/yourbundle/';*/

        $config = $this->getParameter('jims_ueditor');

        if ($config['config_file'] == 'Resources/config/config.json') {
            $config_file = __DIR__."/../".$config['config_file'];
        } else {
            $config_file = $config['config_file'];
        }

        $this->CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($config_file)), true);
    }

    public function indexAction()
    {
        $this->initConfig();
        //print_r($this->CONFIG);
        //die();

        $action = $_GET['action'];

        switch ($action) {
            case 'config':
                $result =  json_encode($this->CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                //$result = include("action_upload.php");
                $result = $this->upload();
                break;

            /* 列出图片 */
            case 'listimage':
                //$result = include("action_list.php");
                $result = $this->getList();
                break;
            /* 列出文件 */
            case 'listfile':
                //$result = include("action_list.php");
                $result = $this->getList();
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                //$result = include("action_crawler.php");
                $result = $this->crawler();
                break;

            default:
                $result = json_encode(array(
                  'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                  'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
        return new Response('');
    }

    protected function upload()
    {
        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $config = array(
                  "pathFormat" => $this->CONFIG['imagePathFormat'],
                  "maxSize" => $this->CONFIG['imageMaxSize'],
                  "allowFiles" => $this->CONFIG['imageAllowFiles']
                );
                $fieldName = $this->CONFIG['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                  "pathFormat" => $this->CONFIG['scrawlPathFormat'],
                  "maxSize" => $this->CONFIG['scrawlMaxSize'],
                  "allowFiles" => $this->CONFIG['scrawlAllowFiles'],
                  "oriName" => "scrawl.png"
                );
                $fieldName = $this->CONFIG['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                  "pathFormat" => $this->CONFIG['videoPathFormat'],
                  "maxSize" => $this->CONFIG['videoMaxSize'],
                  "allowFiles" => $this->CONFIG['videoAllowFiles']
                );
                $fieldName = $this->CONFIG['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                  "pathFormat" => $this->CONFIG['filePathFormat'],
                  "maxSize" => $this->CONFIG['fileMaxSize'],
                  "allowFiles" => $this->CONFIG['fileAllowFiles']
                );
                $fieldName = $this->CONFIG['fileFieldName'];
                break;
        }

        /* 生成上传实例对象并完成上传 */
        //$up = new Uploader($fieldName, $config, $base64);
        $up = $this->get("ueditor.uploader");
        $up->init($fieldName, $config, $base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }

    protected function getList()
    {
        /* 判断类型 */
        switch ($_GET['action']) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $this->CONFIG['fileManagerAllowFiles'];
                $listSize = $this->CONFIG['fileManagerListSize'];
                $path = $this->CONFIG['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $this->CONFIG['imageManagerAllowFiles'];
                $listSize = $this->CONFIG['imageManagerListSize'];
                $path = $this->CONFIG['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
        $files = $this->getfiles($path, $allowFiles);
        if (!count($files)) {
            return json_encode(array(
              "state" => "no match file",
              "list" => array(),
              "start" => $start,
              "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--){
            $list[] = $files[$i];
        }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

        /* 返回数据 */
        $result = json_encode(array(
          "state" => "SUCCESS",
          "list" => $list,
          "start" => $start,
          "total" => count($files)
        ));

        return $result;
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    protected function getfiles($path, $allowFiles, &$files = array())
    {
        if (!is_dir($path)) return null;
        if(substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                        $files[] = array(
                          'url'=> substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                          'mtime'=> filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }


    protected function crawler()
    {
        /* 上传配置 */
        $config = array(
          "pathFormat" => $this->CONFIG['catcherPathFormat'],
          "maxSize" => $this->CONFIG['catcherMaxSize'],
          "allowFiles" => $this->CONFIG['catcherAllowFiles'],
          "oriName" => "remote.png"
        );
        $fieldName = $this->CONFIG['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            //$item = new Uploader($imgUrl, $config, "remote");
            $item = $this->get("ueditor.uploader");
            $item->init($imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, array(
              "state" => $info["state"],
              "url" => $info["url"],
              "size" => $info["size"],
              "title" => htmlspecialchars($info["title"]),
              "original" => htmlspecialchars($info["original"]),
              "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return json_encode(array(
          'state'=> count($list) ? 'SUCCESS':'ERROR',
          'list'=> $list
        ));
    }
    
}
