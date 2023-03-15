<?php

namespace bin\database\datas;

class datas
{

    private $list;
    private $paths;
    private $session;

    function __construct()
    {
        $this->paths = new \bin\epaphrodite\path\paths;
        $this->session = new \bin\epaphrodite\auth\session_auth;
    }

    /**
     * Liste des types utilisateurs
     * @param int $key
     * @return array
     */
    public function user(?int $key = null)
    {

        $list =
            [
                1 => 'SUPER ADMINISTRATEUR',
                2 => 'ADMINISTRATEUR',
                3 => 'UTILISATEUR',

            ];

        if ($key === null) {
            return $list;
        } else {
            return $list[$key];
        }
    }

    /**
     * Liste des types utilisateurs
     * @param int $key
     * @return array
     */
    public function other_user_list(?int $key = null)
    {

        $list =
            [
                1 => 'ADMINISTRATEUR',
                2 => 'SOUS-DIRECTEUR',
                3 => 'AGENT CENTRAL',
                4 => 'AGENT REGION'

            ];

        if ($key === null) {
            return $list;
        } else {
            return $list[$key];
        }
    }

    /**
     * Liste des menus de l'application
     * @param int $key
     * @return array
     */
    public function modules(?string $key = null)
    {

        $list =
            [
                'profil' => 'MON PROFIL',
                'agence' => 'GEST. AGENCES',
                'import' => 'GEST. IMPORTATION',
                'right' => 'GEST. DROITS ACCESS',
                'users' => 'GEST. UTILISATEURS',

            ];

        if ($key === null) {
            return $list;
        } else {
            return $list[$key];
        }
    }

    /**
     * Liste des contenus des menus de l'application
     * @param int $key
     * @return array
     */
    public function yedidiah(?string $key = null, ?string $value = null)
    {

        $paths =
            [

                'umdp' => ['apps' => 'profil', 'libelle' => "Modifier mot de passe", 'path' => $this->paths->admin('users', 'modifier_mot_de_passe'), 'right' => 'umdp'],
                'uinfos' => ['apps' => 'profil', 'libelle' => "Modifier mes infos", 'path' => $this->paths->admin('users', 'modifier_infos_perso'), 'right' => 'uinfos'],
                'ajoutagence' => ['apps' => 'agence', 'libelle' => "Ajouter des agences", 'path' => $this->paths->admin('users', 'ajouter_des_agences'), 'right' => 'ajoutagence'],
                'listagence' => ['apps' => 'agence', 'libelle' => "Liste des agences", 'path' => $this->paths->admin('users', 'list_des_agences'), 'right' => 'listagence'],
                'importusers' => ['apps' => 'import', 'libelle' => "Importation des utilisateurs", 'path' => $this->paths->admin('users', 'import_des_utilisateurs'), 'right' => 'importusers'],
                'listusers' => ['apps' => 'users', 'libelle' => "Liste des utilisateurs", 'path' => $this->paths->admin('users', 'liste_des_utilisateurs'), 'right' => 'listusers'],

            ];

        if ($key === null) {
            return $paths;
        } else {
            return $paths[$key][$value];
        }
    }

    /**
     * Specific path list
     * @param int $right
     * @return string
     */
    private function specific_path(?string $right = null)
    {

        $type = $this->session->type();

        $list =
            [

                'adduright' =>
                [
                    1 => $this->paths->admin('users', 'import_demande_matricule_eleves'),
                    2 => $this->paths->admin('users', 'import_demande_matricule_eleves'),
                    3 => NULL, 4 => NULL, 5 => NULL, 6 => NULL,  7 => NULL,
                ],
                'guseright' =>
                [
                    1 => $this->paths->admin('users', 'liste_droits_users'),
                    2 => $this->paths->admin('users', 'liste_droits_users'),
                    3 => NULL, 4 => NULL, 5 => NULL, 6 => NULL,  7 => NULL,
                ],
                'addusers' =>
                [
                    1 => $this->paths->admin('users', 'ajouter_des_utilisateurs'),
                    2 => $this->paths->admin('users', 'ajouter_des_utilisateurs'),
                    3 => NULL, 4 => NULL, 5 => NULL, 6 => NULL,  7 => NULL,
                ],
                'gusers' =>
                [
                    1 => $this->paths->admin('users', 'liste_des_utilisateurs'),
                    2 => $this->paths->admin('users', 'liste_des_utilisateurs'),
                    3 => NULL, 4 => NULL, 5 => NULL, 6 => NULL,  7 => NULL,
                ],

            ];

        return $list[$right][$type];
    }

    /**
     * Liste des autorisations
     * @param int $key
     * @return array
     */
    public function autorisation(?string $key = null)
    {

        $this->list =
            [
                1 => 'REFUSER',
                2 => 'AUTORISER',
            ];

        if ($key === null) {
            return $this->list;
        } else {
            return $this->list[$key];
        }
    }
}
