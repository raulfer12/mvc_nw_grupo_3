<?php

    namespace Dao\Security;

    if (version_compare(phpversion(), '7.4.0', '<')) {
            define('PASSWORD_ALGORITHM', 1);  //BCRYPT
    } 
    else 
    {
        define('PASSWORD_ALGORITHM', '2y');  //BCRYPT
    }

    use Exception;

    class Security extends \Dao\Table
    {
        public static function getAll()
        {
            return self::obtenerRegistros("SELECT * FROM usuarios ORDER BY usuario_tipo;;", array());
        }

        static public function newUsuarioClient($usuario_email, $usuario_nombre, $usuario_pswd)
        {
            if (!\Utilities\Validators::IsValidEmail($usuario_email)) 
            {
                throw new Exception("Correo no es válido");
            }
            if (!\Utilities\Validators::IsValidPassword($usuario_pswd)) 
            {
                throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
            }

            $usuario = self::_usuarioStruct();
            //Tratamiento de la Contraseña
            $hashedPassword = self::_hashPassword($usuario_pswd);

            unset($usuario["usuario_id"]);
            unset($usuario["usuario_fching"]);
            unset($usuario["usuario_pswd_chg"]);

            $usuario["usuario_email"] = $usuario_email;
            $usuario["usuario_nombre"] = $usuario_nombre;
            $usuario["usuario_pswd"] = $hashedPassword;
            $usuario["usuario_pswd_est"] = Estados::ACTIVO;
            $usuario["usuario_pswd_exp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
            $usuario["usuario_est"] = Estados::ACTIVO;
            $usuario["usuario_act_cod"] = hash("sha256", $usuario_email.time());
            $usuario["usuario_tipo"] = usuario_tipo::PUBLICO;

            $sqlIns = "INSERT INTO `usuarios` (`usuario_email`, `usuario_nombre`, `usuario_pswd`,
                `usuario_fching`, `usuario_pswd_est`, `usuario_pswd_exp`, `usuario_est`, `usuario_act_cod`,
                `usuario_pswd_chg`, `usuario_tipo`)
                VALUES
                ( :usuario_email, :usuario_nombre, :usuario_pswd,
                now(), :usuario_pswd_est, :usuario_pswd_exp, :usuario_est, :usuario_act_cod,
                now(), :usuario_tipo);";

            return self::executeNonQuery($sqlIns, $usuario);
        }

        static public function newUsuarioAdmin($usuario_email, $usuario_nombre, $usuario_pswd, $usuario_tipo)
        {
            if (!\Utilities\Validators::IsValidEmail($usuario_email)) 
            {
                throw new Exception("Correo no es válido");
            }
            
            if (!\Utilities\Validators::IsValidPassword($usuario_pswd)) 
            {
                throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
            }      
            
            $usuario = self::_usuarioStruct();
            //Tratamiento de la Contraseña
            $hashedPassword = self::_hashPassword($usuario_pswd);

            unset($usuario["usuario_id"]);
            unset($usuario["usuario_fching"]);
            unset($usuario["usuario_pswd_chg"]);

            $usuario["usuario_email"] = $usuario_email;
            $usuario["usuario_nombre"] = $usuario_nombre;
            $usuario["usuario_pswd"] = $hashedPassword;
            $usuario["usuario_pswd_est"] = Estados::ACTIVO;
            $usuario["usuario_pswd_exp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
            $usuario["usuario_est"] = Estados::ACTIVO;
            $usuario["usuario_act_cod"] = hash("sha256", $usuario_email.time());
            $usuario["usuario_tipo"] = $usuario_tipo;

            $sqlIns = "INSERT INTO `usuarios` (`usuario_email`, `usuario_nombre`, `usuario_pswd`,
                `usuario_fching`, `usuario_pswd_est`, `usuario_pswd_exp`, `usuario_est`, `usuario_act_cod`,
                `usuario_pswd_chg`, `usuario_tipo`)
                VALUES
                ( :usuario_email, :usuario_nombre, :usuario_pswd,
                now(), :usuario_pswd_est, :usuario_pswd_exp, :usuario_est, :usuario_act_cod,
                now(), :usuario_tipo);";

            return self::executeNonQuery($sqlIns, $usuario);
        }

        static public function updateUsuarioAdmin($usuario_id, $usuario_email, $usuario_nombre, $usuario_est,
        $usuario_tipo)
        {
            if (!\Utilities\Validators::IsValidEmail($usuario_email)) 
            {
                throw new Exception("Correo no es válido");
            }

            $usuario = self::_usuarioStruct();

            unset($usuario["usuario_pswd"]);
            unset($usuario["usuario_fching"]);   
            unset($usuario["usuario_pswd_est"]);  
            unset($usuario["usuario_pswd_exp"]);  
            unset($usuario["usuario_est"]);     
            unset($usuario["usuario_act_cod"]);   
            unset($usuario["usuario_pswd_chg"]); 

            $usuario["usuario_id"] = $usuario_id;
            $usuario["usuario_email"] = $usuario_email;
            $usuario["usuario_nombre"] = $usuario_nombre;
            $usuario["usuario_est"] = $usuario_est;
            $usuario["usuario_act_cod"] = hash("sha256", $usuario_email.time());
            $usuario["usuario_tipo"] = $usuario_tipo;

            $sqlIns = "UPDATE `usuarios` SET usuario_email=:usuario_email, usuario_nombre=:usuario_nombre, 
            usuario_est=:usuario_est, usuario_act_cod=:usuario_act_cod, usuario_tipo=:usuario_tipo WHERE usuario_id=:usuario_id";

            return self::executeNonQuery($sqlIns, $usuario);
        }

        static public function updateUsuarioWithPswdAdmin($usuario_id, $usuario_email, $usuario_nombre, $usuario_pswd, 
        $usuario_est, $usuario_tipo)
        {
            if (!\Utilities\Validators::IsValidEmail($usuario_email)) 
            {
                throw new Exception("Correo no es válido");
            }
            
            if (!\Utilities\Validators::IsValidPassword($usuario_pswd)) 
            {
                throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
            }      
            
            $usuario = self::_usuarioStruct();
            //Tratamiento de la Contraseña
            $hashedPassword = self::_hashPassword($usuario_pswd);

            unset($usuario["usuario_fching"]);
            unset($usuario["usuario_pswd_chg"]);

            $usuario["usuario_id"] = $usuario_id;
            $usuario["usuario_email"] = $usuario_email;
            $usuario["usuario_nombre"] = $usuario_nombre;
            $usuario["usuario_pswd"] = $hashedPassword;
            $usuario["usuario_pswd_est"] = Estados::ACTIVO;
            $usuario["usuario_pswd_exp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
            $usuario["usuario_est"] = $usuario_est;
            $usuario["usuario_act_cod"] = hash("sha256", $usuario_email.time());
            $usuario["usuario_tipo"] = $usuario_tipo;

            $sqlIns = "UPDATE `usuarios` SET `usuario_email`=:usuario_email, `usuario_nombre`=:usuario_nombre, 
            `usuario_pswd`=:usuario_pswd, `usuario_pswd_est`=:usuario_pswd_est, `usuario_pswd_exp`=:usuario_pswd_exp, 
            `usuario_est`=:usuario_est, `usuario_act_cod`=:usuario_act_cod, `usuario_pswd_chg`=now(), `usuario_tipo`=:usuario_tipo
            WHERE usuario_id=:usuario_id;";
            return self::executeNonQuery($sqlIns, $usuario);
        }

        public static function deleteUsuarioAdmin($usuario_id)
        {
            $delsql = "DELETE FROM usuarios WHERE usuario_id=:usuario_id;";
            return self::executeNonQuery
            (
                $delsql,
                array("usuario_id" => $usuario_id)
            );
        }

        public static function getUsuariobyId($usuario_id)
        {
            $sqlstr = "SELECT * FROM usuarios WHERE usuario_id = :usuario_id LIMIT 1;";
            return self::obtenerUnRegistro($sqlstr, array("usuario_id"=>$usuario_id));
        }

        static public function getUsuarioByEmail($usuario_email)
        {
            $sqlstr = "SELECT * FROM `usuarios` where `usuario_email` = :usuario_email ;";
            $params = array("usuario_email"=>$usuario_email);

            return self::obtenerUnRegistro($sqlstr, $params);
        }

        public static function getUsuarioDifferbyEmail($usuario_id, $usuario_email)
        {
            $sqlstr = "SELECT * FROM usuarios WHERE usuario_id!=:usuario_id AND usuario_email=:usuario_email";
            return self::obtenerRegistros($sqlstr, array("usuario_id"=>$usuario_id, "usuario_email"=>$usuario_email));
        }
        
        static private function _saltPassword($usuario_pswd)
        {
            return hash_hmac(
                "sha256",
                $usuario_pswd,
                \Utilities\Context::getContextByKey("PWD_HASH")
            );
        }

        static private function _hashPassword($password)
        {
            return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
        }

        static public function verifyPassword($raw_password, $hash_password)
        {
            return password_verify(
                self::_saltPassword($raw_password),
                $hash_password
            );
        }

        static private function _usuarioStruct()
        {
            return array(
                "usuario_id"      => "",
                "usuario_email"    => "",
                "usuario_nombre"     => "",
                "usuario_pswd"     => "",
                "usuario_fching"   => "",
                "usuario_pswd_est"  => "",
                "usuario_pswd_exp"  => "",
                "usuario_est"      => "",
                "usuario_act_cod"   => "",
                "usuario_pswd_chg"  => "",
                "usuario_tipo"     => "",
            );
        }

        static public function getFeature($funcion_id)
        {
            $sqlstr = "SELECT * FROM funciones WHERE funcion_id=:funcion_id;";
            $featuresList = self::obtenerRegistros($sqlstr, array("funcion_id"=>$funcion_id));
            return count($featuresList) > 0;
        }

        static public function addNewFeature($funcion_id, $funcion_dsc, $funcion_est, $funcion_tipo)
        {
            $sqlins = "INSERT INTO `funciones` (`funcion_id`, `funcion_dsc`, `funcion_est`, `funcion_tipo`)
                VALUES (:funcion_id , :funcion_dsc , :funcion_est , :funcion_tipo);";

            return self::executeNonQuery(
                $sqlins,
                array(
                    "funcion_id" => $funcion_id,
                    "funcion_dsc" => $funcion_dsc,
                    "funcion_est" => $funcion_est,
                    "funcion_tipo" => $funcion_tipo
                )
            );
        }

        static public function getFeatureByUsuario($usuario_id, $funcion_id)
        {
            $sqlstr = "SELECT * from funcionesroles a INNER JOIN rolesusuario b ON a.rol_id = b.rol_id 
            WHERE a.Funcionrol_est = 'ACT' AND b.usuario_id=:usuario_id AND a.funcion_id=:funcion_id LIMIT 1;";
            $resultados = self::obtenerRegistros(
                $sqlstr,
                array(
                    "usuario_id"=> $usuario_id,
                    "funcion_id" => $funcion_id
                )
            );
            return count($resultados) > 0;
        }

        static public function getRol($rol_id)
        {
            $sqlstr = "SELECT * FROM roles WHERE rol_id=:rol_id;";
            $featuresList = self::obtenerRegistros($sqlstr, array("rol_id" => $rol_id));
            return count($featuresList) > 0;
        }

        static public function addNewRol($rol_id, $rol_dsc, $rol_est)
        {
            $sqlins = "INSERT INTO `roles` (`rol_id`, `rol_dsc`, `rol_est`)
            VALUES (:rol_id, :rol_dsc, :rol_est);";

            return self::executeNonQuery(
                $sqlins,
                array(
                    "rol_id" => $rol_id,
                    "rol_dsc" => $rol_dsc,
                    "rol_est" => $rol_est
                )
            );
        }
        
        static public function getRolesByUsuario($usuario_id, $rol_id)
        {
            $sqlstr = "SELECT * FROM roles a INNER JOIN 
            rolesusuario b ON a.rol_id = b.rol_id WHERE a.rol_est = 'ACT'
            AND b.usuario_id=:usuario_id AND a.rol_id=:rol_id LIMIT 1;";
            $resultados = self::obtenerRegistros(
                $sqlstr,
                array(
                    "usuario_id" => $usuario_id,
                    "rol_id" => $rol_id
                )
            );
            return count($resultados) > 0;
        }

        static public function getFuncionesByRolesUsuario($usuario_id, $rol_id)
        {
            $sqlstr = "SELECT * FROM roles a INNER JOIN 
            rolesusuario b ON a.rol_id = b.rol_id WHERE a.rol_est = 'ACT'
            AND b.usuario_id=:usuario_id AND a.rol_id=:rol_id LIMIT 1;";
            $resultados = self::obtenerRegistros(
                $sqlstr,
                array(
                    "usuario_id" => $usuario_id,
                    "rol_id" => $rol_id
                )
            );
            return count($resultados) > 0;
        }

        static public function searchUsuarios($usuario_busqueda)
        {
            $sqlstr = "SELECT * FROM usuarios WHERE usuario_email LIKE :usuario_busqueda
            OR usuario_nombre LIKE :usuario_busqueda OR usuario_fching LIKE :usuario_busqueda 
            OR usuario_pswd_est LIKE :usuario_busqueda OR usuario_pswd_exp LIKE :usuario_busqueda 
            OR usuario_est LIKE :usuario_busqueda OR usuario_tipo LIKE :usuario_busqueda ORDER BY usuario_tipo;";   
            return self::obtenerRegistros($sqlstr, array("usuario_busqueda"=>"%".$usuario_busqueda."%"));
        }

        private function __construct()
        {
        }
        private function __clone()
        {
        }
    }
?>
