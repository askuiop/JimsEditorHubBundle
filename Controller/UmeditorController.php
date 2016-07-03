<?php

namespace Jims\EditorHubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UmeditorController extends Controller
{
    public function imageUpAction()
    {
        $user_config = $this->getParameter('jims_umeditor');
        //上传配置
        $config = array(
          "savePath" => $user_config['save_path'] ,             //存储文件夹
          "maxSize" => $user_config['max_size']  ,             //允许的文件最大尺寸，单位KB
          "allowFiles" => $user_config['allow_files']             //允许的文件格式
        );
        //上传文件目录
        $Path = $user_config['save_path'];

        //背景保存在临时目录中
        $config[ "savePath" ] = $Path;
        ////$up = new Uploader( "upfile" , $config );
        $up = $this->get("umeditor.uploader");
        $up->init( "upfile" , $config );

        $type = !empty($_REQUEST['type'])?$_REQUEST['type']:'';
        $callback=!empty($_GET['callback'])?$_GET['callback']:false;

        $info = $up->getFileInfo();
        /**
         * 返回数据
         */
        if($callback) {
            echo '<script>'.$callback.'('.json_encode($info).')</script>';
        } else {
            echo json_encode($info);
        }

        return new Response('');
    }

    /**
     * 这个函数是干吗的？ 我不知道...先放这里吧
     * @return Response
     */
    public function getContentAction()
    {
        echo '<script src="../third-party/jquery.min.js"></script>
                <script src="../third-party/mathquill/mathquill.min.js"></script>
                <link rel="stylesheet" href="../third-party/mathquill/mathquill.css"/>
                <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>';

        //获取数据
        $content =  htmlspecialchars($_POST['myEditor']);

        //存入数据库或者其他操作

        //显示
        echo  "<div class='content'>".htmlspecialchars_decode($content)."</div>";
        return new Response('');
    }
}
