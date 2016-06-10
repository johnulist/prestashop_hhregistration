
<?php

/**
 * Module Hh Registration : Ajout de champs au formulaire d'inscription
 *
 */
class hhregistration extends Module {


    /** Extensions autorisées pour l'envoi de fichiers */
    private $_registration_allowed_extensions = array('pdf','doc','docx','jpg','png','gif','txt');

    /* Nom du dossier dans lequel sont envoyés les fichiers */
    private $_upload_dir = 'files/';

    public function __construct() {
		
        $this->name = 'hhregistration';
        $this->tab = 'hhennes';
        $this->author = 'hhennes';
        $this->version = '0.1.1';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('HH Registration');
        $this->description = $this->l('Sample module which show how to add fields to registration');
    }

    /**
     * Installation du module : Installation Standard + greffe sur les hooks nécessaires
     * @return boolean
     */
    public function install() {
        if (
                !parent::install() || !$this->registerHook('displayCustomerAccountForm') || !$this->registerHook('actionCustomerAccountAdd')
        )
            return false;

        return true;
    }

    /**
     * Désintallation du module
     * @return boolean
     */
    public function uninstall() {
        if (!parent::uninstall())
            return false;
        return true;
    }

    /**
     * Nouveaux champs à rajouter sur le formulaire de création de compte
     * @param type $params
     */
    public function hookDisplayCustomerAccountForm($params) {

        //Affichage du template du module ( situé dans views/templates/hook )
        return $this->display(__FILE__, 'hookDisplayCustomerAccountForm.tpl');
    }

    /**
     * Traitement des nouveaux champs du formulaire d'inscription
     */
    public function hookActionCustomerAccountAdd($params)
    {
        //Gestion de l'upload via la classe d'upload prestashop

        //Pour un seul envoi
        /*$uploader = new Uploader('file_input'); //Renseigner ici le nom du fichier envoyés
        $uploader->setAcceptTypes($this->_registration_allowed_extensions)
                ->setCheckFileSize(UploaderCore::DEFAULT_MAX_SIZE)
                ->setSavePath(dirname(__FILE__) . '/' . $this->_upload_dir)
                ->process();*/

        //Pour plusieurs envois
        $uploader = new Uploader();
        $uploader->setAcceptTypes($this->_registration_allowed_extensions)
                ->setCheckFileSize(UploaderCore::DEFAULT_MAX_SIZE)
                ->setSavePath(dirname(__FILE__) . '/' . $this->_upload_dir);

        //Mettre ici les différents fichiers à envoyer (Possible aussi de faire une boucle sur $_FILES )
        if ( isset($_FILES['file_input']))
            $uploader->upload ($_FILES['file_input']);
        if ( isset($_FILES['file_input2']))
            $uploader->upload ($_FILES['file_input2']);

    }

}
