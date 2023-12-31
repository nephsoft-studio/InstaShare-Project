<?php

require_once CMDM_PATH . "/lib/helpers/Validate/Interface.php";

class CMDM_Validate_FileExtension implements CMDM_Validate_Interface {

    protected $_errors = array();
    protected $_allowed = array();
    const NOT_VALID = '%label%: Allowed extensions are - %extensions%';

    public function __construct(array $tokens) {
        $this->_allowed = array_map('strtolower', $tokens);
    }

    public function getErrors() {
        return $this->_errors;
    }

    public function isValid($value) {
        $this->_errors = array();
        if (is_array($value))
            $value = $value['name'];
        $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
        if ($ext == 'php' || $ext == 'php3' || $ext == 'php4' || $ext == 'phtml'){
            $message = 'PHP extension is not allowed';
            $this->_errors[] = $message;
            return false;
        }
        if (!in_array($ext, $this->_allowed)) {
            $message = str_replace('%extensions%', implode(', ', $this->_allowed), self::NOT_VALID);
            $this->_errors[] = $message;
            return false;
        } else
            return true;
    }

}

?>
