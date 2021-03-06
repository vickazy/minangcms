<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('m_database');
        $this->load->helper('db_helper');
        $this->load->helper(array('posts_helper','service_helper'));
        
        //widgetAdd("search","Menampilkan search terbaru pada widget");
    }
    
    function index()
    {
        echo "Search Widget";
    }
    
    function generate(){
    	$pos=$this->input->get('pos');
    	$theme=$this->input->get('theme');
    	$param=$this->input->get('divider');
    	$d['pos']=$pos;
    	$d['theme']=$theme;
    	$d['slug']=$theme."_sidebar_".$pos."_item";
    	$d['termdata']=$this->input->get('data');
		$d['widgetdata']=$this->input->get('widgetdata');
		
		$d['parentid']=$this->input->get('parentid');
		$d['divider']=$param;
		$this->load->view('widget/search/widgetview',$d);
	}
	
	function configwidget(){
		$d['termdata']=$this->input->get('data');
		$d['widgetdata']=$this->input->get('widgetdata');		
		$d['parentid']=$this->input->get('parentid');
		$this->load->view('widget/search/configview',$d);
	}
    
    function delete(){
    	$this->load->library('m_database');
		$did=$this->input->post('id');
		$s=array(
		'term_id'=>$did,
		);
		$this->m_database->deleteRow('terms',$s);
		$this->m_database->deleteRow('termstaxonomy',$s);
		
		echo json_encode('ok');
	}
	
	function update(){
		$this->load->library('m_database');
		$did=$this->input->post('id');		
		$title=$this->input->post('title');
		$name=dbField('terms','term_id',$did,'name');
		$slug=dbField('terms','term_id',$did,'slug');
		$parent=dbField('terms','term_id',$did,'term_parent');
		$json=json_encode(array(
		'prefix'=>'search',
		'title'=>$title,
		));
		updateTerms($did,"sidebar",$name,$slug,"",$parent,$json);
		
		
		echo json_encode('ok');
	}
}