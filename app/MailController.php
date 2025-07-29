<?php
    include "phpmailer/class.phpmailer.php";
    include "phpmailer/class.smtp.php";
    
    class MailController {
        // Configuración SYSOP //
        /*
        const SMTP_FROMNAME = 'SIENNA MX';
        const SMTP_USERNAME = '#####';
        const IS_SMTP = true;
        const SMTP_HOST = '#####';
        const SMTP_PORT = '#####';
        const SMTP_PASSWORD = '#####';
        private $mail;
        public function __construct(){
            $this->mail = new PHPMailer();
            $this->mail->CharSet = 'UTF-8';
            $this->mail->From = self::SMTP_USERNAME;
            $this->mail->FromName = self::SMTP_FROMNAME;
            $this->mail->SMTPAuth = self::IS_SMTP;
            if (self::IS_SMTP) {
                $this->mail->IsSMTP();
                $this->mail->Host = self::SMTP_HOST;
                $this->mail->Username = self::SMTP_USERNAME;
                $this->mail->Password = self::SMTP_PASSWORD;
            }
        }
        */
        
        // CONFIGURACIÓN Y DESPLIEGUE EN SIENNA //
        const SMTP_FROMNAME = 'SIENNA MX';
        const SMTP_USERNAME = 'AKIA26BTXSH4GSM2CT67';
        const IS_SMTP = true;
        const SMTP_HOST = 'email-smtp.us-east-2.amazonaws.com';
        const SMTP_PORT = '465';
        const SMTP_PASSWORD = 'BBH/Obgv98EBLLfZkayDvVgSr0KDM5q5wCgX8ElCi+qK';
        private $mail;
        public function __construct(){
            try {
                $this->mail = new PHPMailer();
                $this->mail->CharSet = 'UTF-8';
                $this->mail->From = 'notificaciones@atencionsienna.mx';
                $this->mail->FromName = self::SMTP_FROMNAME;
                $this->mail->SMTPAuth = self::IS_SMTP;
                $this->mail->SMTPSecure = 'ssl';
                $this->mail->Port = self::SMTP_PORT;
                if (self::IS_SMTP) {
                    $this->mail->IsSMTP();
                    $this->mail->Host = self::SMTP_HOST;
                    $this->mail->Username = self::SMTP_USERNAME;
                    $this->mail->Password = self::SMTP_PASSWORD;
                }
            } catch (Exception $e) {
                $errorMessage = 'Exception caught: ' . $e->getMessage();
                $this->logError($errorMessage); // Registrar el error
                return $errorMessage;
            }
        }
        
        public function sendNoticeCustomers($dataNotice, $emails, $dataUser, $dataFolder) {
            try {
                $this->mail->Subject = "SIENNA MX || NUEVO SEGUIMIENTO";
                $this->mail->IsHTML(true);
                $this->mail->ClearReplyTos();
                $this->mail->addReplyTo("notificaciones@atencionsienna.mx", 'SIENNA MX');
                
                // Iterar sobre los correos electrónicos
                foreach ($emails as $email) {
                    $this->mail->addAddress($email);
                }
                
                // Generar el cuerpo del correo usando la plantilla
                ob_start();
                // Combinar todas las variables en un solo array asociativo
                $templateData = array_merge($dataNotice, $dataUser, $dataFolder);
                extract($templateData, EXTR_SKIP);
                include 'emailsTemplates/sendNoticeCustomers.php';
                $this->mail->Body = ob_get_clean();
                
                // Enviar el correo
                if (!$this->mail->send()) {
                    $errorMessage = 'Mailer Error: ' . $this->mail->ErrorInfo;
                    $this->logError($errorMessage); // Registrar el error
                    return $errorMessage;
                }

                // Limpiar destinatarios para evitar problemas en futuros envíos
                $this->mail->clearAddresses();
                return true;
            } catch (Exception $e) {
                $errorMessage = 'Exception caught: ' . $e->getMessage();
                $this->logError($errorMessage); // Registrar el error
                return $errorMessage;
            }
        }
        
        /* Función para registrar errores en un archivo .log */
        private function logError($message) {
            $logFile = __DIR__ . '/MailError.log'; // Archivo donde se almacenarán los errores
            $date = date('Y-m-d H:i:s'); // Fecha y hora actual
            $formattedMessage = "[{$date}] ERROR: {$message}\n"; // Formato del mensaje
            file_put_contents($logFile, $formattedMessage, FILE_APPEND); // Escribir en el archivo
        }
    }
?>