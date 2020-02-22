<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $base_url;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->base_url = base_url();
        $this->load->model('Savefile_model', 'Savefile');
        $this->load->library('grocery_CRUD');
        $this->checkStatusLogin();
    }

    public function checkStatusLogin()
    {
        $s_email = $this->session->userdata('sa_email');
        $page = $this->uri->segment(2);
        if ($page != 'login' && (empty($s_email))) {
            header('Location: ' . $this->base_url . 'admin/login');
            exit;
        } else if ($page == 'login' && !empty($s_email)) {
            header('Location: ' . $this->base_url . 'admin');
            exit;
        }
    }

    public function login()
    {
        if (!empty($_POST['submit'])) {
            if (!empty($_POST['email'])) $data['email'] = trim($_POST['email']);
            if (!empty($_POST['pass'])) $data['password'] = sha1(trim($_POST['pass']));
            if (empty($data['email']) || empty($data['password'])) {
                $this->load->view('login_view.php');
                return;
            }
            $sql = 'SELECT a.email,a.full_name,a.level,a.id             FROM zn_account_admin a             where a.email="' . ($this->db->escape_str($data['email'])) . '" and a.password="' . $data['password'] . '"';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $newdata = array('sa_email' => $row['email'], 'sa_name' => 'ADMIN');
                $this->session->set_userdata($newdata);
                header('Location: ' . $this->base_url . 'admin/');
                exit;
            }
        }
        $this->load->view('login_view.php');
    }

    public function logout()
    {
        $arrSession = $this->session->all_userdata();
        $arrSession = array_keys($arrSession);
        $this->session->unset_userdata($arrSession);
        header('Location: ' . $this->base_url . 'admin/');
        exit;
    }

    public function admin_output($output = null)
    {
        $this->load->view('admin_view.php', $output);
    }

    public function index()
    {
        $this->zn_account_admin();
    }

    public function zn_account_admin()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('zn_account_admin');
        $crud->columns('full_name', 'email', 'level');
        $crud->fields('full_name', 'email', 'password', 'level');
        $crud->required_fields('full_name', 'email');
        $crud->callback_add_field('password', function () {
            return '<input type="password" minlength="8" value="" name="password">';
        });
        $crud->callback_edit_field('password', array($this, 'edit_field_password'));
        $crud->callback_before_insert(array($this, 'callback_password'));
        $crud->callback_before_update(array($this, 'callback_password'));
        $output = $crud->render();
        $this->admin_output($output);
    }

    public function uploadFileAdmin()
    {
        $linkFolder = PATH_STSTEM . '/zeanniTheme/img/';
        $url = '/zeanniTheme/img/' . $this->Savefile->up_img('upload', $linkFolder);
        $funcNum = $_GET['CKEditorFuncNum'];
        $CKEditor = $_GET['CKEditor'];
        $langCode = $_GET['langCode'];
        $message = '';
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

    function edit_field_password()
    {
        return '<input type="password" minlength="8" value="" name="password">';
    }

    function callback_password($post_array, $primary_key = '')
    {
        if (empty($post_array['password'])) unset($post_array['password']); else             $post_array['password'] = sha1($post_array['password']);
        return $post_array;
    }

    public function DOCUMENT_RULE()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('DOCUMENT_RULE');
        $crud->display_as('ID', 'ID');
        $crud->display_as('TITLE', 'TITLE');
        $crud->display_as('DISPATCH_NUMBER', 'DISPATCH_NUMBER');
        $crud->display_as('AGENCY_ISSUED', 'AGENCY_ISSUED');
        $crud->display_as('VALIDITY_STATUS', 'VALIDITY_STATUS');
        $crud->display_as('DATE_POSTED', 'DATE_POSTED');
        $crud->display_as('EFFECTIVE_DATE', 'EFFECTIVE_DATE');
        $crud->display_as('THE_SIGNER', 'THE_SIGNER');
        $crud->display_as('NAME_FILES', 'NAME_FILES');
        $crud->display_as('ATTACHED_FILES', 'ATTACHED_FILES');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function KEY_TAG()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('KEY_TAG');
        $crud->display_as('ID', 'ID');
        $crud->display_as('NAME', 'NAME');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function NEWS()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('NEWS');
        $crud->display_as('ID', 'ID');
        $crud->display_as('TITLE', 'TITLE');
        $crud->display_as('IMG', 'IMG');
        $crud->display_as('EDITOR', 'EDITOR');
        $crud->display_as('DATE_SUBMITTED', 'DATE_SUBMITTED');
        $crud->display_as('COUNT_VIEW', 'COUNT_VIEW');
        $crud->display_as('SHORT_DESCRIPTION', 'SHORT_DESCRIPTION');
        $crud->display_as('POST', 'POST');
        $crud->display_as('HIGHLIGHTS', 'HIGHLIGHTS');
        $crud->display_as('STATUS', 'STATUS');
        $crud->set_field_upload('IMG', 'zeanniTheme/img/');
        $crud->callback_before_insert(array($this, "NEWS_callback"));
        $crud->callback_before_update(array($this, "NEWS_callback"));
        $output = $crud->render();
        $this->admin_output($output);
    }

    public function NEWS_KEYTAG()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('NEWS_KEYTAG');
        $crud->display_as('ID', 'ID');
        $crud->display_as('NEWS_ID', 'NEWS_ID');
        $crud->display_as('KEY_TAG_ID', 'KEY_TAG_ID');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_BIDERS()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_BIDERS');
        $crud->display_as('BUSSINESS_REGISTRATION_NUM', 'BUSSINESS_REGISTRATION_NUM');
        $crud->display_as('BUSSINESS_REGISTRATION_DATE', 'BUSSINESS_REGISTRATION_DATE');
        $crud->display_as('BIDER_NAME', 'BIDER_NAME');
        $crud->display_as('BIDER_EN_NAME', 'BIDER_EN_NAME');
        $crud->display_as('BUSSINESS_FIELD', 'BUSSINESS_FIELD');
        $crud->display_as('BUSSINESS_TYPE', 'BUSSINESS_TYPE');
        $crud->display_as('TEL_NUM', 'TEL_NUM');
        $crud->display_as('FAX_NUM', 'FAX_NUM');
        $crud->display_as('AUTHORIZED_CAPITAL', 'AUTHORIZED_CAPITAL');
        $crud->display_as('PROVINCE', 'PROVINCE');
        $crud->display_as('ADDRESS', 'ADDRESS');
        $crud->display_as('COUNTRY', 'COUNTRY');
        $crud->display_as('EMPLOYEE_NUM', 'EMPLOYEE_NUM');
        $crud->display_as('WEBSITE', 'WEBSITE');
        $crud->display_as('WORKING_NAME', 'WORKING_NAME');
        $crud->display_as('APPROVAL_DATE', 'APPROVAL_DATE');
        $crud->display_as('EFFECTIVE_DATE', 'EFFECTIVE_DATE');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('LEADER_NAME', 'LEADER_NAME');
        $crud->display_as('LEADER_IDENTITY_NUM', 'LEADER_IDENTITY_NUM');
        $crud->display_as('LEADER_TEL_NUM', 'LEADER_TEL_NUM');
        $crud->display_as('LEADER_EMAIL', 'LEADER_EMAIL');
        $crud->display_as('LEGALEST_AGENT', 'LEGALEST_AGENT');
        $crud->display_as('CURATOR_NAME', 'CURATOR_NAME');
        $crud->display_as('CURATOR_IDENTITY_NUM', 'CURATOR_IDENTITY_NUM');
        $crud->display_as('DEPARTMENT', 'DEPARTMENT');
        $crud->display_as('POSITION', 'POSITION');
        $crud->display_as('CURATOR_FAX', 'CURATOR_FAX');
        $crud->display_as('CURATOR_TEL_NUM', 'CURATOR_TEL_NUM');
        $crud->display_as('CURATOR_MOBI_NUM', 'CURATOR_MOBI_NUM');
        $crud->display_as('CURATOR_EMAIL', 'CURATOR_EMAIL');
        $crud->display_as('AGENT_NAME', 'AGENT_NAME');
        $crud->display_as('AGENT_IDENTITY_NUM', 'AGENT_IDENTITY_NUM');
        $crud->display_as('CERTIFICATE_MANAGE_OFFCICE', 'CERTIFICATE_MANAGE_OFFCICE');
        $crud->display_as('TAXNUMBER', 'TAXNUMBER');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_BIDER_SELECTIONS()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_BIDER_SELECTIONS');
        $crud->display_as('BIDER_SELECTION_ID', 'BIDER_SELECTION_ID');
        $crud->display_as('NAME', 'NAME');
        $crud->display_as('PROCURING_CODE', 'PROCURING_CODE');
        $crud->display_as('INVESTORS', 'INVESTORS');
        $crud->display_as('TYPE', 'TYPE');
        $crud->display_as('APPROVAL_STATUS', 'APPROVAL_STATUS');
        $crud->display_as('VALUE', 'VALUE');
        $crud->display_as('APPROVAL_OFFICE', 'APPROVAL_OFFICE');
        $crud->display_as('APPROVAL_DOC_NUM', 'APPROVAL_DOC_NUM');
        $crud->display_as('APPROVAL_DATE', 'APPROVAL_DATE');
        $crud->display_as('CREATE_DATE', 'CREATE_DATE');
        $crud->display_as('VERSION_NUM', 'VERSION_NUM');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('BID_NUM', 'BID_NUM');
        $crud->display_as('SOURCE', 'SOURCE');
        $crud->display_as('DEL_FLAG', 'DEL_FLAG');
        $crud->display_as('INVESTOR', 'INVESTOR');
        $crud->display_as('BID_STATUS', 'BID_STATUS');
        $crud->required_fields('BIDER_SELECTION_ID');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_BIDINGS()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_BIDINGS');
        $crud->display_as('BIDING_ID', 'BIDING_ID');
        $crud->display_as('BUSSINESS_REGISTRATION_NUM', 'BUSSINESS_REGISTRATION_NUM');
        $crud->display_as('PRICE_BIDING', 'PRICE_BIDING');
        $crud->display_as('PRICE_ACCEPT', 'PRICE_ACCEPT');
        $crud->display_as('PRICE_JUDGE', 'PRICE_JUDGE');
        $crud->display_as('TECHNICAL_SCORE', 'TECHNICAL_SCORE');
        $crud->display_as('EXCUTE_CONTRACT', 'EXCUTE_CONTRACT');
        $crud->display_as('SELECTION_BIDER_REASON', 'SELECTION_BIDER_REASON');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('APPROVAL_CERTIFICATE', 'APPROVAL_CERTIFICATE');
        $crud->display_as('STATUS', 'STATUS');
        $crud->display_as('FINISH_DATE', 'FINISH_DATE');
        $crud->display_as('PRICE_PROPOSED', 'PRICE_PROPOSED');
        $crud->display_as('BIDER_NAME', 'BIDER_NAME');
        $crud->display_as('BID_BUSSINESS_REGISTRATION_NUM', 'BID_BUSSINESS_REGISTRATION_NUM');
        $crud->display_as('FIELD', 'FIELD');
        $crud->display_as('NOTI_TYPE', 'NOTI_TYPE');
        $crud->display_as('INVESTOR', 'INVESTOR');
        $crud->display_as('PACKAGE_NAME', 'PACKAGE_NAME');
        $crud->display_as('BID_TYPE', 'BID_TYPE');
        $crud->display_as('PROJECT_NAME', 'PROJECT_NAME');
        $crud->display_as('PROCURING_NAME', 'PROCURING_NAME');
        $crud->display_as('BIDER_SELECTION_TYPE', 'BIDER_SELECTION_TYPE');
        $crud->display_as('VERSION', 'VERSION');
        $crud->display_as('BID_BID_PACKAGE_CODE', 'BID_BID_PACKAGE_CODE');
        $crud->display_as('ADDRESS', 'ADDRESS');
        $crud->display_as('BID_PACKAGE_CODE', 'BID_PACKAGE_CODE');
        $crud->display_as('PUBLIC_DATE', 'PUBLIC_DATE');
        $crud->display_as('BUYER', 'BUYER');
        $crud->display_as('BIDSUCC', 'BIDSUCC');
        $crud->display_as('BIDPROJECT', 'BIDPROJECT');
        $crud->display_as('BIDNM', 'BIDNM');
        $crud->display_as('APPROVAL_DATE', 'APPROVAL_DATE');
        $crud->display_as('CODELINK', 'CODELINK');
        $crud->display_as('CODEKH', 'CODEKH');
        $crud->display_as('BIDDERCOUNT', 'BIDDERCOUNT');
        $crud->required_fields('BIDING_ID');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_BID_PACKAGES()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_BID_PACKAGES');
        $crud->display_as('BID_PACKAGE_ID', 'BID_PACKAGE_ID');
        $crud->display_as('BID_PACKAGE_CODE', 'BID_PACKAGE_CODE');
        $crud->display_as('PACKAGE_NAME', 'PACKAGE_NAME');
        $crud->display_as('CONTENT', 'CONTENT');
        $crud->display_as('PROCURING_CODE', 'PROCURING_CODE');
        $crud->display_as('BID_TYPE', 'BID_TYPE');
        $crud->display_as('PROJECT_NAME', 'PROJECT_NAME');
        $crud->display_as('FIELD', 'FIELD');
        $crud->display_as('TYPE', 'TYPE');
        $crud->display_as('FUNDING_SOURCE', 'FUNDING_SOURCE');
        $crud->display_as('BIDER_SELECTION_TYPE', 'BIDER_SELECTION_TYPE');
        $crud->display_as('START_DOC_DATE', 'START_DOC_DATE');
        $crud->display_as('FINISH_DOC_DATE', 'FINISH_DOC_DATE');
        $crud->display_as('DOC_PRICE', 'DOC_PRICE');
        $crud->display_as('DOC_PLACE', 'DOC_PLACE');
        $crud->display_as('START_SUBMISSION_DATE', 'START_SUBMISSION_DATE');
        $crud->display_as('FINISH_SUBMISSION_DATE', 'FINISH_SUBMISSION_DATE');
        $crud->display_as('SUBMISSION_PLACE', 'SUBMISSION_PLACE');
        $crud->display_as('OPEN_DATE', 'OPEN_DATE');
        $crud->display_as('CLOSE_DATE', 'CLOSE_DATE');
        $crud->display_as('OPEN_PLACE', 'OPEN_PLACE');
        $crud->display_as('PRICE', 'PRICE');
        $crud->display_as('GUARANTEED_AMOUNT', 'GUARANTEED_AMOUNT');
        $crud->display_as('BID_SECURITY', 'BID_SECURITY');
        $crud->display_as('STAGE_BIDDING', 'STAGE_BIDDING');
        $crud->display_as('VIEW_TURN', 'VIEW_TURN');
        $crud->display_as('COMMENCEMENT_DATE', 'COMMENCEMENT_DATE');
        $crud->display_as('CREATE_DATE', 'CREATE_DATE');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('NOTI_TYPE', 'NOTI_TYPE');
        $crud->display_as('BIDER_SELECTION_ID', 'BIDER_SELECTION_ID');
        $crud->display_as('PERIOD_TIME', 'PERIOD_TIME');
        $crud->display_as('PREQUALIFICATION_STATUS', 'PREQUALIFICATION_STATUS');
        $crud->display_as('PREQUALIFICATION_CODE', 'PREQUALIFICATION_CODE');
        $crud->display_as('PRE_NOTI_STATUS', 'PRE_NOTI_STATUS');
        $crud->display_as('PRE_START_DOC_DATE', 'PRE_START_DOC_DATE');
        $crud->display_as('PRE_FINISH_DOC_DATE', 'PRE_FINISH_DOC_DATE');
        $crud->display_as('PRE_DOC_PRICE', 'PRE_DOC_PRICE');
        $crud->display_as('PRE_DOC_PLACE', 'PRE_DOC_PLACE');
        $crud->display_as('PRE_START_SUBMISSION_DATE', 'PRE_START_SUBMISSION_DATE');
        $crud->display_as('PRE_DEAD_SUBMISSION_DATE', 'PRE_DEAD_SUBMISSION_DATE');
        $crud->display_as('PRE_SUBMISSION_PLACE', 'PRE_SUBMISSION_PLACE');
        $crud->display_as('PRE_OPEN_DATE', 'PRE_OPEN_DATE');
        $crud->display_as('PRE_OPEN_PLACE', 'PRE_OPEN_PLACE');
        $crud->display_as('PRE_CREATE_DATE', 'PRE_CREATE_DATE');
        $crud->display_as('PRE_UPDATE_DATE', 'PRE_UPDATE_DATE');
        $crud->display_as('PREQUALIFICATION_CONTENT', 'PREQUALIFICATION_CONTENT');
        $crud->display_as('IS_SPECIFIED_PACKAGE', 'IS_SPECIFIED_PACKAGE');
        $crud->display_as('NOTI_VERSION_NUM', 'NOTI_VERSION_NUM');
        $crud->display_as('PACKAGE_NUM', 'PACKAGE_NUM');
        $crud->display_as('BID_SELECTION_TIME', 'BID_SELECTION_TIME');
        $crud->display_as('PROVINCE', 'PROVINCE');
        $crud->display_as('EXCUTE_CONTRACT_TIME', 'EXCUTE_CONTRACT_TIME');
        $crud->display_as('DEL_FLAG', 'DEL_FLAG');
        $crud->display_as('INVESTOR', 'INVESTOR');
        $crud->display_as('DETAIL_FIELD', 'DETAIL_FIELD');
        $crud->display_as('QUALIFI_EXPERIENCE', 'QUALIFI_EXPERIENCE');
        $crud->display_as('FIELD_ID', 'FIELD_ID');
        $crud->display_as('CODEKH', 'CODEKH');
        $crud->display_as('NAMEKH', 'NAMEKH');
        $crud->display_as('ESTIMATE_PRICE', 'ESTIMATE_PRICE');
        $crud->display_as('RECEIVE_TYPE', 'RECEIVE_TYPE');
        $crud->display_as('FAILEDCONTRACTYEAR', 'FAILEDCONTRACTYEAR');
        $crud->display_as('FINACIALACTRESULTFROMYEAR', 'FINACIALACTRESULTFROMYEAR');
        $crud->display_as('FINACIALACTRESULTTOYEAR', 'FINACIALACTRESULTTOYEAR');
        $crud->display_as('MINIMUMREVENUE', 'MINIMUMREVENUE');
        $crud->display_as('ANNUALREVENUEYEARS', 'ANNUALREVENUEYEARS');
        $crud->display_as('CONTRACTVALUE', 'CONTRACTVALUE');
        $crud->display_as('EXPERIENCEYEARS', 'EXPERIENCEYEARS');
        $crud->display_as('EXPERIENCEYEARDESC', 'EXPERIENCEYEARDESC');
        $crud->display_as('OTHERSERVICES', 'OTHERSERVICES');
        $crud->display_as('TIME_UPDATE_FIELD', 'TIME_UPDATE_FIELD');
        $crud->display_as('LOCATION', 'LOCATION');
        $crud->display_as('LOCATION_CODE', 'LOCATION_CODE');
        $crud->display_as('CODELINK', 'CODELINK');
        $crud->display_as('BIDDERCARE', 'BIDDERCARE');
        $crud->display_as('BIDDERCARE_VER', 'BIDDERCARE_VER');
        $crud->required_fields('BID_PACKAGE_ID');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_PACKAGE_INFO()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_PACKAGE_INFO');
        $crud->display_as('ID', 'ID');
        $crud->display_as('PACKAGE_NUM', 'PACKAGE_NUM');
        $crud->display_as('CODE', 'CODE');
        $crud->display_as('PACKAGE_NAME', 'PACKAGE_NAME');
        $crud->display_as('VALUE', 'VALUE');
        $crud->display_as('FUNDING_SOURCE', 'FUNDING_SOURCE');
        $crud->display_as('BIDER_SELECTION_TYPE', 'BIDER_SELECTION_TYPE');
        $crud->display_as('SELECTION_TIME', 'SELECTION_TIME');
        $crud->display_as('CONTRACT_TYPE', 'CONTRACT_TYPE');
        $crud->display_as('EXCUTE_TIME', 'EXCUTE_TIME');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('CANCEL_STATUS', 'CANCEL_STATUS');
        $crud->display_as('DETAIL_FIELD', 'DETAIL_FIELD');
        $crud->display_as('BID_STATUS', 'BID_STATUS');
        $crud->display_as('INTERNAL_EXTERNAL', 'INTERNAL_EXTERNAL');
        $crud->display_as('ITEM_IS_PQ', 'ITEM_IS_PQ');
        $crud->display_as('INTERNET', 'INTERNET');
        $crud->display_as('SELECTION_PROCEDURE', 'SELECTION_PROCEDURE');
        $crud->display_as('IS_FOLLOW', 'IS_FOLLOW');
        $crud->display_as('FIELD_ID', 'FIELD_ID');
        $crud->display_as('PACKAGE_INDEX', 'PACKAGE_INDEX');
        $crud->display_as('TIME_UPDATE_FIELD', 'TIME_UPDATE_FIELD');
        $crud->display_as('LOCATION', 'LOCATION');
        $crud->display_as('LOCATION_CODE', 'LOCATION_CODE');
        $crud->display_as('CODELINK', 'CODELINK');
        $crud->display_as('VERSION', 'VERSION');
        $crud->required_fields('ID');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function TBL_PROCURINGS()
    {
        $crud = new grocery_CRUD();
        $crud->set_table('TBL_PROCURINGS');
        $crud->display_as('PROCURING_CODE', 'PROCURING_CODE');
        $crud->display_as('BUSSINESS_REGISTRATION_NUM', 'BUSSINESS_REGISTRATION_NUM');
        $crud->display_as('PROCURING_NAME', 'PROCURING_NAME');
        $crud->display_as('BRIEF_NAME', 'BRIEF_NAME');
        $crud->display_as('PROCURING_EN_NAME', 'PROCURING_EN_NAME');
        $crud->display_as('AGENCY_TYPE', 'AGENCY_TYPE');
        $crud->display_as('DIRECTLY_TYPE', 'DIRECTLY_TYPE');
        $crud->display_as('TEL_NUM', 'TEL_NUM');
        $crud->display_as('FAX_NUM', 'FAX_NUM');
        $crud->display_as('TAX_NUM', 'TAX_NUM');
        $crud->display_as('PROVINCE', 'PROVINCE');
        $crud->display_as('ADDRESS', 'ADDRESS');
        $crud->display_as('WEBSITE', 'WEBSITE');
        $crud->display_as('WORKING_NAME', 'WORKING_NAME');
        $crud->display_as('BUSSINESS_TYPE', 'BUSSINESS_TYPE');
        $crud->display_as('APPROVAL_DATE', 'APPROVAL_DATE');
        $crud->display_as('EFFECTIVE_DATE', 'EFFECTIVE_DATE');
        $crud->display_as('UPDATE_DATE', 'UPDATE_DATE');
        $crud->display_as('CURATOR_NAME', 'CURATOR_NAME');
        $crud->display_as('CURATOR_IDENTITY_NUM', 'CURATOR_IDENTITY_NUM');
        $crud->display_as('DEPARTMENT', 'DEPARTMENT');
        $crud->display_as('CURATOR_FAX', 'CURATOR_FAX');
        $crud->display_as('CURATOR_TEL_NUM', 'CURATOR_TEL_NUM');
        $crud->display_as('CURATOR_MOBI_NUM', 'CURATOR_MOBI_NUM');
        $crud->display_as('CURATOR_EMAIL', 'CURATOR_EMAIL');
        $crud->display_as('AGENT_NAME', 'AGENT_NAME');
        $crud->display_as('AGENT_IDENTITY_NUM', 'AGENT_IDENTITY_NUM');
        $crud->display_as('CERTIFICATE_MANAGE_OFFCICE', 'CERTIFICATE_MANAGE_OFFCICE');
        $crud->required_fields('PROCURING_CODE');

        $output = $crud->render();
        $this->admin_output($output);
    }

    public function NEWS_callback($post_array, $primary_key)
    {
        if (!empty($post_array["IMG"])) {
            $post_array["IMG"] = "/zeanniTheme/img/" . str_replace("/zeanniTheme/img/", "", $post_array["IMG"]);
        }
        return $post_array;
    }
}