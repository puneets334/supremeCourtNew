<?php

namespace App\Controllers\AdminReport;

use App\Controllers\BaseController;
use App\Models\AdminReport\AdminSearchModel;
use App\Models\NewCase\DropdownListModel;
use App\Libraries\Zip;

class Search extends BaseController
{
    protected $AdminSearchModel;
    protected $Dropdown_list_model;

    public function __construct()
    {
        parent::__construct();
        $this->AdminSearchModel = new AdminSearchModel();
        $this->Dropdown_list_model = new DropdownListModel();
        helper(['url']);
        ini_set('memory_limit', '51200M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
        ini_set('max_execution_time', 0);
        error_reporting(2);
        if (empty(getSessionData('login')['ref_m_usertype_id'])) {
            redirect('login');
            exit(0);
        }
        $allowed_users_array = array(USER_ADMIN, USER_ADMIN_READ_ONLY);
        if (!in_array(getSessionData('login')['ref_m_usertype_id'], $allowed_users_array)) {
            redirect('adminDashboard');
            exit(0);
        }
    }

    public function index()
    {
        // pr($_POST);
        $data['sc_case_type'] = $this->Dropdown_list_model->get_sci_case_type();
        // pr($data);
        // $this->load->view('templates/admin_header');
        $this->render('adminReport.search', $data);
        // $this->load->view('templates/footer');
    }

    public function get_list_doc_fromDate_toDate()
    {
        $data = array();
        $params['from_date'] = '';
        $params['to_date'] = '';
        $output = array();
        // $exitCode = 0;
        $validatinError = true;
        // pr(date('Y-m-d', strtotime(str_replace('/','-',$this->request->getPost('from_date')))));
        if (!empty($this->request->getPost('from_date'))) {
            // $from_date = !empty($this->request->getPost('from_date')) ? date('Y-m-d',strtotime(str_replace('/','-',$this->request->getPost('from_date')))) : NULL;
            $from_date = !empty($this->request->getPost('from_date')) ? date('Y-m-d', strtotime($this->request->getPost('from_date'))) : NULL;
            $params['from_date'] = $from_date;
        } else {
            $output['status'] = 'error';
            $output['id'] = 'from_date';
            $output['msg'] = 'Please select from date.';
            $validatinError = false;
            echo "1@@@" . 'Please select from date.';
            exit(0);
        }
        if (!empty($this->request->getPost('to_date'))) {
            // $to_date = !empty($this->request->getPost('to_date')) ? date('Y-m-d',strtotime(strtr($this->request->getPost('to_date'), '/', '-'))) : NULL;
            $to_date = !empty($this->request->getPost('to_date')) ? date('Y-m-d', strtotime($this->request->getPost('to_date'))) : NULL;
            $params['to_date'] = $to_date;
        } else {
            $output['status'] = 'error';
            $output['id'] = 'to_date';
            $output['msg'] = 'Please select to date.';
            $validatinError = false;
            echo "1@@@" . 'Please select to date.';
            exit(0);
        }
        // $params['sc_case_type'] = $this->input->post("sc_case_type");
        $params['sc_case_type'] = $this->request->getPost('sc_case_type');
        $userNameArr = array();
        $doc_list = $this->AdminSearchModel->get_list_doc_fromDate_toDate($params);
        $data['doc_list'] = $doc_list;
        if (!empty($doc_list)) {
            // $this->db->trans_start();
            $efilingcase = 'efilingcase';
            $est_dir = 'uploaded_docs/' . $efilingcase;
            //$est_dir = $efilingcase;
            if (!is_dir($est_dir)) {
                $uold = umask(0);
                if (!is_dir($efilingcase)) {
                    mkdir($efilingcase, 0777, true);
                }
                umask($uold);
            }
            foreach ($doc_list as $row) {
                $diarized_on = !empty($row['diarized_on']) ? date('d_m_Y', strtotime(str_replace('/', '_', $row['diarized_on']))) : '';
                // $diarized_on = !empty($row['diarized_on']) ? date('d-m-Y', strtotime($row['diarized_on'])) : NULL;
                $sc_diary_number = $row['sc_diary_num'] . $row['sc_diary_year'];
                $casetype = $row['casetype'];
                $path_main_file = $row['ducs_path'];
                if (!empty($diarized_on) && !empty($sc_diary_number) && !empty($casetype) && !empty($path_main_file)) {
                    $date_diarized_on_dir = $est_dir . '/' . $diarized_on;
                    $casetype_dir = $est_dir . '/' . $diarized_on . '/' . $casetype;
                    $sc_diary_number_dir = $est_dir . '/' . $diarized_on . '/' . $casetype . '/' . $sc_diary_number;
                    $path_main_fileExp = explode('/', $path_main_file);
                    $file_name = $path_main_fileExp[4];
                    $new_file_path = $sc_diary_number_dir . '/' . $file_name;
                    if (file_exists($path_main_file)) {
                        if (!is_dir($date_diarized_on_dir)) {
                            $uold = umask(0);
                            mkdir($date_diarized_on_dir, 0777, true);
                            umask($uold);
                        }
                        if (!is_dir($casetype_dir)) {
                            $uold = umask(0);
                            mkdir($casetype_dir, 0777, true);
                            umask($uold);
                        }
                        if (!is_dir($sc_diary_number_dir)) {
                            $uold = umask(0);
                            mkdir($sc_diary_number_dir, 0777, true);
                            umask($uold);
                        }
                        copy($path_main_file, $new_file_path);
                    }
                }
            }
            // File name
            $zipFolderName = 'efilingcase.zip';
            $folderPath = 'uploaded_docs/efilingcase/';
            $zipFileName = 'uploaded_docs/efilingcase.zip';
            // Use the zip command-line utility to create the archive
            if (is_dir($folderPath)) {
                // $zip = new \CodeIgniter\Files\ZipCompression();
                // $zip->open('uploaded_docs/efilingcase.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
                // $zip->addFile('uploaded_docs/efilingcase/');
                // $zip->close();
                // pr($zip);
                // if ($zip->result() !== true) {
                //     throw new \RuntimeException('Failed to create the zip file.');
                // }
                // $command = "zip -r ".$zipFileName." ".$folderPath." 2>&1";
                // pr($exitCode);
                // exec($command, $output, $exitCode);
                $zip = new \ZipArchive();
                if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                    $this->addFilesToZip($zip, $folderPath);
                    $exitCode = $zip->close();
                    if ($exitCode === true) {
                        // if ($exitCode === 0) {
                        foreach ($doc_list as $row) {
                            $diarized_on = !empty($row['diarized_on']) ? date('d_m_Y', strtotime(str_replace('/', '_', $row['diarized_on']))) : '';
                            $sc_diary_number = $row['sc_diary_num'] . $row['sc_diary_year'];
                            $casetype = $row['casetype'];
                            $path_main_file = $row['ducs_path'];
                            if (!empty($diarized_on) && !empty($sc_diary_number) && !empty($casetype) && !empty($path_main_file)) {
                                $date_diarized_on_dir = $est_dir . '/' . $diarized_on;
                                $casetype_dir = $est_dir . '/' . $diarized_on . '/' . $casetype;
                                $sc_diary_number_dir = $est_dir . '/' . $diarized_on . '/' . $casetype . '/' . $sc_diary_number;
                                $path_main_fileExp = explode('/', $path_main_file);
                                $file_name = $path_main_fileExp[4];
                                $new_file_path = $sc_diary_number_dir . '/' . $file_name;
                                if (file_exists($new_file_path)) {
                                    unlink($new_file_path);
                                }
                                if (empty($sc_diary_number_dir)) {
                                    rmdir($sc_diary_number_dir);
                                }
                                if (empty($casetype_dir)) {
                                    rmdir($casetype_dir);
                                }
                                if (empty($date_diarized_on_dir)) {
                                    rmdir($date_diarized_on_dir);
                                }
                            }
                        }
                        $this->download();
                        echo "200@@@" . 'Archive created successfully.'; exit(0);
                        // echo "200@@@" . 'Please wait sometime awaiting download Diarized files.';
                        // exit(0);
                    } else {
                        // echo "Error creating the archive:";
                        $error = '';
                        foreach ($output as $line) {
                            $error .= "<br>$line";
                            // echo "<br>$line";
                        }
                        echo "1@@@" . $error . 'Error creating the archive.'; exit(0);
                    }
                    // echo "4@@@".$error.'Something went wrong please check then try again';
                    // exit(0);
                    // echo "ZIP file created successfully: " . $zipFileName;
                    // } else {
                    //     echo "Failed to create ZIP file.";
                    // }
                } else {
                    echo "Failed to open ZIP file."; exit(0);
                }
                // pr();
            }
        } else {
            echo "3@@@" . 'Data not found.'; exit(0);
        }
        // $data['sc_case_type'] = $this->Dropdown_list_model->get_sci_case_type();
        // $this->load->view('templates/admin_header');
        // $this->render('adminReport.search', $data);
        // $this->load->view('templates/footer');
    }


    function download()
    {
        $zipFolderName = "efilingcase.zip";
        $folderPath = 'uploaded_docs/efilingcase.zip';
        if (file_exists($folderPath)) {
            // adjust the below absolute file path according to the folder you have downloaded
            // the zip file
            // I have downloaded the zip file to the current folder
            $absoluteFilePath = $folderPath;
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            // content-type has to be defined according to the file extension (filetype)
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipFolderName) . '";');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($absoluteFilePath));
            readfile($absoluteFilePath);
            if (unlink($folderPath)) {
                //echo "success";
            } else {
                //echo "Failure";
            }
            redirect("adminReport/search");
            exit();
        } else {
            echo 'filename not exist =' . $zipFolderName;
        }
    }

    function download_delete()
    {
        $zipFolderName = "efilingcase.zip";
        $folderPath = 'uploaded_docs/efilingcase.zip';
        if (file_exists($folderPath)) {
            if (unlink($folderPath)) {
                echo "successfully deleted efilingcase.zip";
            } else {
                echo "Failure";
            }
        } else {
            echo 'filename not exist =' . $zipFolderName;
        }
    }
    private function addFilesToZip(\ZipArchive $zip, $dir, $basePath = '')
    {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $fullPath = $dir . '/' . $entry;
            $localPath = $basePath . ($basePath ? '/' : '') . $entry;
            if (is_dir($fullPath)) {
                $this->addFilesToZip($zip, $fullPath, $localPath);
            } else {
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, $localPath);
                } else {
                    echo "File not found: $fullPath";
                }
            }
        }
        closedir($handle);
    }
}
