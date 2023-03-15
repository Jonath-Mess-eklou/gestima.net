<?php

namespace bin\epaphrodite\env;

class env
{
    protected $chaine_translate;

    /**
     * Tronquer le nombre de mot du text ou de la phrase
     * 
     * @param string|null $string
     * @param int|1 $limit
     * 
     * @return string
     *  */
    public function truncate(?string $string = null, ?int $limit = 1, $separator = '...')
    {
        if (strlen($string) > $limit) {
            $newlimit = $limit - strlen($separator);
            $finalchaine = substr($string, 0, $newlimit + 1);
            return preg_replace("/&#039;/", "'", (substr($finalchaine, 0, strrpos($finalchaine, ' ')))) . $separator;
        }

        return $this->chaine($string);
    }

    /* 
        Renvoyer la date sous forme de chaine de caractere  
    */
    public function date_chaine($date)
    {

        if ($date == NULL) {
            $date = date('Y-m-d');
        }
        setlocale(LC_ALL, 'fr_FR') . ': ';
        return strftime("%A %d %B %Y", strtotime($date));
    }

    /**
     * Transforme code ISO
     *
     * @param string|null $chaine
     * 
     * @return mixed
     */
    public function chaine(?string $chaine = null)
    {

        $pattern = ["/&#039;/", "/&#224;/", "/&#225;/", "/&#226;/", "/&#227;/", "/&#228;/", "/&#230;/", "/&#231;/", "/&#232;/", "/&#233;/", "/&#234;/", "/&#235;/", "/&#238;/", "/&#239;/", "/&#244;/", "/&#251;/", "/&amp;/"];

        $rep_pat = ["'", "à", "á", "â", "ã", "ä", "æ", "ç", "è", "é", "ê", "ë", "î", "ï", "ô", "û", "&"];

        return !empty($chaine) ? preg_replace($pattern, $rep_pat, $chaine) : NULL;
    }

    /**
     * For transcoding values in an Excel generated (french)
     *
     * @param string $chaine
     * @return string
     */
    public function translate_fr(string $chaine)
    {

        $this->chaine_translate = iconv('Windows-1252', 'UTF-8//TRANSLIT', $chaine);

        return $this->chaine_translate;
    }

    /**
     * Import files in server
     *
     * @param string $Lien_fichier
     * @return void
     */
    public function import_fichier(string $Lien_fichier)
    {

        $charger = $Lien_fichier . '/' . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], $charger);
    }

    /**
     * Vider un repertoire
     *
     * @param string $directory
     * @param string $extension
     * @return void
     */
    public function delete_dir(string $directory, string $extension)
    {

        array_map('unlink', glob($directory . '*' . $extension));

        return true;
    }

    /**
     * Nettoyer les espaces entre les lettres
     *
     * @param string $chaines|null
     * @return string
     */
    public function no_space(?string $chaines = null)
    {

        return str_replace(' ', '', $chaines);
    }

    public function nbre_format($num, $dec, $separator)
    {
        return number_format($num, $dec, ',', ' ');
    }

    /**
     * Nettoyer les espaces entre les lettres
     *
     * @param string $chaines|null
     * @return string
     */
    public function reel(?string $chaines = null)
    {

        $chaines = str_replace(' ', '', $chaines);

        return str_replace(',', '.', $chaines);
    }

    /**
     * Nettoyer les espaces entre les lettres
     *
     * @param string $chaines|null
     * @return string
     */
    public function explode_datas(?string $datas = null, ?string $separator = '', ?int $nbre = 0)
    {

        $chaines = explode($separator, $datas);

        return $chaines[$nbre];
    }

    public function strpad($number, $pad_length, $pad_string)
    {
        return str_pad($number, $pad_length, $pad_string, STR_PAD_LEFT);
    }
}
