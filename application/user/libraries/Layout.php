<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    private $title;
    private $js_file;
    private $css_file;
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');


        // default CSS and JS that they must be load in any pages
        $this->addCSS(base_url("assets/vendor/bootstrap/css/bootstrap.css"));
        $this->addCSS(base_url("assets/vendor/bootstrap/css/fasion-style.css"));

//        $this->addJS(base_url('assets/js/jquery.min.js'));
//        $this->addJS(base_url('assets/js/bootstrap.min.js'));


    }

    public function addCSS($name)
    {
        $css = new stdClass();
        $css->file = $name;
        $this->css_file[] = $css;
    }

    public function show($page, $data = null)
    {
        if (!file_exists('application/user/views/' . $page . '.php')) {
            show_404();
        } else {
            $this->data['crud'] = $data;
            $this->load_JS_and_css();
            $this->load_title();

            $this->data['html_content'] = $this->CI->load->view($page . '.php', $this->data, true);
            $this->CI->load->view('layout/tem.php', $this->data);
        }
    }

    private function load_JS_and_css()
    {
        $this->data['html_CSS'] = '';
        $this->data['html_JS'] = '';
        if ($this->css_file) {
            foreach ($this->css_file as $css) {
                $this->data['html_CSS'] .= "<link rel='stylesheet' type='text/css' href=" . $css->file . ">" . "\n";
            }
        }

        if ($this->js_file) {
            foreach ($this->js_file as $js) {
                $this->data['html_JS'] .= "<script type='text/javascript' src=" . $js->file . "></script>" . "\n";
            }
        }
    }

    private function load_title()
    {
        $this->data['html_title'] = '';

        if ($this->title) {
            $this->data['html_title'] = $this->title->name;
        }

    }

    public function show_message($page, $data = null)
    {
        if (!file_exists('application/user/views/' . $page . '.php')) {
            show_404();
        } else {
            $this->load_JS_and_css();
            $this->load_title();

            $this->data['message'] = $data;
            $this->data['html_content'] = $this->CI->load->view($page . '.php', $this->data, true);
            $this->CI->load->view('layout/content_msg.php', $this->data);
        }
    }

    public function addJS($name)
    {
        $js = new stdClass();
        $js->file = $name;
        $this->js_file[] = $js;
    }

    public function add_title($name)
    {
        $html = new stdClass();
        $html->name = $name;
        $this->title = $html;
    }

    private function init_menu()
    {
        // your code to init menus
        // it's a sample code you can init some other part of your page


    }
}