<?php

namespace bin\epaphrodite\define;

class text_messages
{
    private $datas_type;

    public function answers($typeansers)
    {

        $this->datas_type[] =
            [
                'language' => 'french',
                '403-title' => 'ERREUR 403',
                '404-title' => 'ERREUR 404',
                '419-title' => 'ERREUR 419',
                '500-title' => 'ERREUR 500',
                'session_name' => 'ep_session',
                'token_name' => 'token_crf_ep',
                '403' => 'Acces restreint !!!',
                'back' => "Retour page d'accueil",
                'author' => 'Agence Epaphrodite',
                'description' => 'agence epaphrodite',
                'denie' => "Traitement impossible !!!",
                '419' => 'Votre session a expirée !!!',
                'site-title' => 'EPAPHRODITE FRAMEWORK',
                'mdpnotsame' => 'mot de passe incorrecte',
                '404' => 'Oops! Aucune page trouvée !!!',
                '500' => 'Internal server error',
                'error_text' => 'Erreur txt epaphrodite',
                'noformat' => 'Le format du fichier incorrecte !',
                'vide' => 'Veuillez remplir tous champs svp !!!',
                'login-wrong' => 'Login ou mot de passe incorrecte',
                'succes' => 'Traitement effectué avec succès !!!',
                'mdpwrong' => "L'ancien mot de passe est incorrecte",
                'connexion' => 'Veuillez vous reconnecter à nouveau svp !',
                'rightexist' => 'Désolé ce droit existe déjà pour ce utilisateur',
                'send' => 'Félicitation votre message a été envoyé avec succès !!!',
                'no-data' => 'Désolé aucune information ne correspond à votre demande',
                'done' => 'Félicitation votre inscription a été effectué avec succès !!!',
                'erreur' => "Désolé un problème est survenu lors de l'enregistrement !!!",
                'errordeleted' => "Désolé un problème est survenu lors de la suppression !!!",
                'errorsending' => "Désolé un problème est survenu lors de l'envoi de votre message !!!",
                'keywords' => "Agence epaphrodite  , Création; site web; digitale; community manager; logo; identité visuelle; marketing; communication; abidjan; Côte d'Ivoire; Afrique; Didier Drogba",
            ];

        return $this->datas_type[0][$typeansers];
    }
}
