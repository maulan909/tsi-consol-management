<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Auth extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() ==  false) {
            $data['title'] = 'Login Page';
            $this->load->view('auth/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('auth/footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['username' => $username])->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['is_active'] == 1) {
                    $this->session->set_userdata([
                        'username' => $username,
                        'role_id' => $user['role_id']
                    ]);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Akun belum aktif, silahkan hubungi Supply Chain Specialist</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Username doesnt exist.</div>');
            redirect('auth');
        }
    }

    public function blocked()
    {
        $this->load->view('auth/blocked.php');
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        redirect('auth');
    }

    private function _sendEmail($email, $token)
    {
        
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'aminkurniawan253@gmail.com',
            'smtp_pass' => 'aminganteng123',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->email->initialize($config);
        $this->email->from('aminkurniawan2539@gmail.com', 'TSI Consolidate Management System');
        $this->email->to($email);

        $this->email->subject('Reset Password');
        $this->email->message('Untuk reset password klik link berikut : <a href="' . base_url('auth/reset') . '?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>. Abaikan jika ini bukan aktivitas anda.');

        $this->email->send();
        return $this->email->print_debugger();
    }

    public function forgot()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
            if ($user) {
                if ($this->db->get_where('user_token', ['email' => $email])->row_array()) {
                    $this->db->delete('user_token', ['email' => $email]);
                }
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token
                ];
                $this->db->insert('user_token', $user_token);
                $status = $this->_sendEmail($email, $token);
                
                // $this->session->set_flashdata('message', '<div class="alert alert-success">' . $status . '</div>');
                $this->session->set_flashdata('message', '<div class="alert alert-success">Link to reset password has been sent, check your email or spam.</div>');
                redirect('auth/forgot');
                
                
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Email doesnt exist or account not active.</div>');
                redirect('auth/forgot');
            }
        } else {
            $data['title'] = 'Forgot Password';
            $this->load->view('auth/header', $data);
            $this->load->view('auth/forgot', $data);
            $this->load->view('auth/footer');
        }
    }

    public function reset()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user_token = $this->db->get_where('user_token', ['email' => $email])->row_array();
        if ($user_token['email']) {
            if ($token == $user_token['token']) {
                $this->session->set_userdata('reset_email', $email);
                $this->changepassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    public function changepassword()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'New Password', 'required|trim|min_length[8]|max_length[15]|matches[password2]', [
            'min_length' => 'Password must be contain 8 - 15 Characters',
            'max_length' => 'Password must be contain 8 - 15 Characters'
        ]);
        $this->form_validation->set_rules('password2', 'New Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run()) {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $this->db->set('password', $password);
            $this->db->where('email', $this->session->userdata('reset_email'));
            $this->db->update('user');
            $this->db->delete('user_token', ['email' => $this->session->userdata('reset_email')]);
            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success">Reset password success! Please login.</div>');
            redirect('auth');
        } else {
            $data['title'] = 'Change Password';
            $this->load->view('auth/header', $data);
            $this->load->view('auth/change-password', $data);
            $this->load->view('auth/footer');
        }
    }
}
