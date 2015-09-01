<?php
class TemplateController {
    public $vars;

    private $template;
    private $loader;
    private $twig;
    private $twig_template;

    public function __construct($template){
        require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/php/Twig-1.18.2/lib/Twig/Autoloader.php');
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/templates');
        $this->twig = new Twig_Environment($this->loader, array('cache' => '/tmp', "auto_reload" => true, "debug" => true));
        $this->twig->addExtension(new Twig_Extension_Debug());
        $this->vars = Array();
        $this->setTemplate($template);
    }

    public function setTemplate($template){
        $this->template = $template;
        $this->twig_template = $this->twig->loadTemplate($this->template);
    }

    public function render(){
        echo $this->twig_template->render($this->vars);
    }
}
?>
