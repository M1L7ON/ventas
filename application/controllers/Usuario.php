<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Usuario extends CI_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
    } 

    function index()
    {
        $data['usuario'] = $this->Usuario_model->todosLosUsuarios();
        
        $this->load->view('layout/header');
        $this->load->view('usuario/index',$data);
        $this->load->view('layout/footer');
    }

    function insert()
    {   
        $this->load->view('layout/header');
        $this->load->view('usuario/insert');
        $this->load->view('layout/footer');
    }  

    public function contar($login)
    {
        echo $this->Usuario_model->contarUsuariosLogin($login);
    }

    function add()
    {   
        $this->formValidation();
		if($this->form_validation->run())     
        {   
            if ($this->Usuario_model->contarUsuariosLogin($this->input->post('login'))==0) {

                $datos = $this->datos();

                $usuario_id = $this->Usuario_model->guardarUsuario($datos);
                redirect('usuario/index');
            }else{
                $data['mensaje'] = "¡El nombre de usuario Existe!";
                $this->load->view('layout/header');
                $this->load->view('usuario/add',$data);
                $this->load->view('layout/footer');
            }
        }
        else
        {            
            $this->load->view('layout/header');
            $this->load->view('usuario/add');
            $this->load->view('layout/footer');
        }
    }  

    public function editar($idusuario)
    {
            $data['usuario'] = $this->Usuario_model->obtenerUsuario($idusuario);
            $this->load->view('layout/header');
            $this->load->view('usuario/edit', $data);
            $this->load->view('layout/footer');
    }

    public function perfil($idusuario)
    {
            $data['usuario'] = $this->Usuario_model->obtenerUsuario($idusuario);
            $this->load->view('layout/header');
            $this->load->view('usuario/perfil', $data);
            $this->load->view('layout/footer');
    }

    public function edit()
    {       
            $idusuario = $this->input->post('idUsuario');
            $this->formValidation();
			if($this->form_validation->run())     
            {   
                if ($this->Usuario_model->obtenerIdUsuario($this->input->post('login'))!=$
                    $idusuario) {

                    $datos = $this->datos();
                    $this->Usuario_model->modificarUsuario($idusuario,$datos);            
                    redirect('usuario/index');
                }else{
                    $data['usuario'] = $this->Usuario_model->obtenerUsuario($idusuario);
                    $data['mensaje'] = "¡El nombre de usuario Existe!";
                    $this->load->view('layout/header');
                    $this->load->view('usuario/edit',$data);
                    $this->load->view('layout/footer');
                }
            }
            else
            {
                $data['usuario'] = $this->Usuario_model->obtenerUsuario($idusuario);
                $this->load->view('layout/header');
                $this->load->view('usuario/edit', $data);
                $this->load->view('layout/footer');
            }
    } 

    function remove($idusuario)
    {
        $usuario = $this->Usuario_model->get_usuario($idusuario);

        // check if the usuario exists before trying to delete it
        if(isset($usuario['idusuario']))
        {
            $this->Usuario_model->delete_usuario($idusuario);
            redirect('usuario/index');
        }
        else
            show_error('The usuario you are trying to delete does not exist.');
    }

    public function formValidation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nombre','Nombre','required|max_length[50]|alpha');
        $this->form_validation->set_rules('ci','CI','required|max_length[10]|alpha_numeric');
        $this->form_validation->set_rules('direccion','Direccion','required|max_length[150]|callback_address');
        $this->form_validation->set_rules('telefono','Telefono','required|max_length[20]|numeric');
        $this->form_validation->set_rules('email','Email','required|max_length[50]|valid_email');
        $this->form_validation->set_rules('cargo','Cargo','required|max_length[5]|');
        $this->form_validation->set_rules('login','Login','required|min_length[5]|max_length[20]');
        $this->form_validation->set_rules('clave','Clave','required|min_length[8]|max_length[64]');
        $this->form_validation->set_rules('rol','rol','required');
    }

    public function datos()
    {
        $clavehash=hash("SHA256",$this->input->post('clave'));
        $foto1 = $this->input->post('foto1');
        if (empty($foto1)) {
            $foto = $this->subirImagen();
        }else{
            $foto = $foto1;
        }
        $params = array(
           'nombre' => $this->input->post('nombre'),
           'ci' => $this->input->post('ci'),
           'direccion' => $this->input->post('direccion'),
           'telefono' => $this->input->post('telefono'),
           'email' => $this->input->post('email'),
           'cargo' => $this->input->post('cargo'),
           'login' => $this->input->post('login'),
           'clave' => $clavehash,
           'foto' => $foto,
           'rol' => $this->input->post('rol'),
        );

        return $params;
    }

    public function subirImagen(){
        $config['upload_path'] = './fotos/usuarios/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';

        $this->load->library('upload',$config);

        if (!$this->upload->do_upload("archivo")) {
            $data['uploadError'] = $this->upload->display_errors();
            echo $this->upload->display_errors();
            return;
           } else {

            $file_info = $this->upload->data();
            $imagen = $file_info['file_name'];
            $data['imagen'] = $imagen;
            
            return $imagen;
        }
    }

    public function cambiarEstado($idUsuario, $estado)
    {
        $cambio = $this->Usuario_model->cambiarEstado($idUsuario,$estado);
        $data['usuario'] = $this->Usuario_model->todosLosUsuarios();
        //print_r($data);
        $this->load->view('layout/header');
        $this->load->view('usuario/index', $data);
        $this->load->view('layout/footer');

    }

    public function logearse(){
        $this->load->view('ingreso');
    }

    public function ingresar(){
        $user = $this->input->post('usuario');
        $psw = hash("SHA256",$this->input->post('contrasenia'));
        $res = $this->Usuario_model->ingresar($user,$psw);
        if ($res == 1){
            redirect(base_url().'Welcome/index');
        }else{
            $data['mensaje'] = "Usuario y/o contraseña incorrectos o el usuario esta Inactivo";
            $this->load->view('ingreso',$data);
        }
    }

    public function cerrar_sesion() {
      $usuario_data = array(
         's_logueado' => FALSE
      );
      $this->session->set_userdata($usuario_data);
      $this->load->view('ingreso');
   }

   /**
     * Address metodo para validar direcciones en form Validation
     * @param $str cadena o numero
     * @return bool
     */
    public function address($str)
    {

        if (preg_match('/^[A-Z0-9áéíóú.# ]+$/i', $str))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('address', 'El campo {field} solo puede contener caracteres alfabéticos . y/o #  .');
            return FALSE;
        }
    }
    
}

