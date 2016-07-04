# JimsEditorHubBundle
 ueditor and umeditor for Symfony 2/3. 为方便使用和学习而整合了ueditor 和 umeditor ，编辑器本身未改动多少以免带来混乱和轮子。 关于ueditor 的相关配置请参考官方文档。
 
## 安装 
 
  1.Step 1 composer 安装
  ```
  composer require jims/editor-hub-bundle
  ```
  或者
  ```
  {
      "require": {
         "kms/froala-editor-bundle": "dev-master"
      }
  }
  
  then
  
  $ composer update
  ```
  2.Step 2 添加到appKernel.php
  ```php
  // app/AppKernel.php

  public function registerBundles()
  {
      $bundles = array(
          // ...
          new Jims\EditorHubBundle\JimsEditorHubBundle(),
      );
  }
  ```
  3.Step 3 Import routes to app/config/routing.yml
  ```yml
  // app/config/routing.yml
  jims_editor:
    resource: "@JimsEditorHubBundle/Resources/config/routing.yml"
    prefix:   /
  ```
  4.Step 4 Import form themes to app/config/config.yml
  ```yml
  //app/config/config.yml
  twig:
    ...
    form_themes:
        - 'JimsEditorHubBundle:Form:form_ueditor_type.html.twig'
        - 'JimsEditorHubBundle:Form:form_umeditor_type.html.twig'
  ```
  5.Step 5 添加设置bundle 配置 于 app/config/config.yml
  ```yml
  //app/config/config.yml
  jims_editor_hub:
    ueditor:
        config_file: ~       #ueditor 的 配置文件的 默认文件： "bundle路径"+Resources/config/config.json
    umeditor:
        save_path:    "upload/umeditor/"                                  #存储文件夹
        max_size:     2000                                                #允许的文件最大尺寸，单位KB
        allow_files:  [ ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ]     #允许的文件格式
  ```
## 使用方法
### symony3:
  ```php
    use Jims\EditorHubBundle\Form\UeditorType;
    ...
    ...
      #使用ueditor
      ->add('content', UeditorType::class, array(
            "attr" => array(
                "style" => "height:400px;width:600px;", //editor转换成编辑器编辑空间尺寸
                "class"=>"jims",
                //通过自定义js, 控制editor toolbars
                #"script" => "window.UEDITOR_CONFIG.toolbars=[['fullscreen', 'source', 'undo', 'redo', 'bold']]"
            ),
        ))
        #使用umeditor
        //->add('content', UmeditorType::class, array(
        //    "attr" => array(
        //        "style" => "width:555px;",
        //        "class"=>"jims",
        //        "script"=>'console.log("This is a ueditor bundle!")'
        //    ),
        //))
  ```
### symfony2:
  ```php
      #使用ueditor
      ->add('content', "ueditor", array(
            "attr" => array(
                "style" => "height:400px;width:600px;", //editor转换成编辑器编辑空间尺寸
                "class"=>"jims",
                //通过自定义js, 控制editor toolbars
                #"script" => "window.UEDITOR_CONFIG.toolbars=[['fullscreen', 'source', 'undo', 'redo', 'bold']]"
            ),
        ))
        #使用umeditor
        //->add('content', "umeditor", array(
        //    "attr" => array(
        //        "style" => "width:555px;",
        //        "class"=>"jims",
        //        "script"=>'console.log("This is a ueditor bundle!")'
        //    ),
        //))
  ```
  
 
