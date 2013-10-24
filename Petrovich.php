<?php

class Petrovich {

    private $rules; //Правила

    const CASE_NOMENATIVE = -1; //именительный
    const CASE_GENITIVE = 0; //родительный
    const CASE_DATIVE = 1; //дательный
    const CASE_ACCUSATIVE = 2; //винительный
    const CASE_INSTRUMENTAL = 3; //творительный
    const CASE_PREPOSITIONAL = 4; //предложный

    const GENDER_ANDROGYNOUS = 0; // Пол не определен
    const GENDER_MALE = 1; // Мужской
    const GENDER_FEMALE = 2; // Женский

    private $middlename; //Шарыпов
    private $firstname; //Пётр
    private $lastname; //Александрович
    
	public $gender = Petrovich::GENDER_ANDROGYNOUS; //Пол male/мужской female/женский

    /**
     * Конструтор класса Петрович
     * загружаем правила из файла rules.json
     */
    function __construct() {
        
        $rules_path = __DIR__.'/rules.json';

        $rules_resourse = fopen($rules_path, 'r');

        if($rules_resourse == false)
            throw new ErrorException('Rules file not found.');

        $rules_array = fread($rules_resourse,filesize($rules_path));

        fclose($rules_resourse);

        $this->rules = get_object_vars(json_decode($rules_array));
    }

    /**
     * Задаём имя и слоняем его
     *
     * @param $firstname
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function firstname($firstname,$case) {
        if(empty($firstname))
            throw new ErrorException('Firstname cannot be empty.');

        $this->firstname = $firstname;
        return $this->inflect($this->firstname,$case,__FUNCTION__);
    }

    /**
     * Задём отчество и склоняем его
     *
     * @param $middlename
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function middlename($middlename,$case) {
        if(empty($middlename))
            throw new ErrorException('Middlename cannot be empty.');

        $this->middlename = $middlename;
        return $this->inflect($this->middlename,$case,__FUNCTION__);
    }

    /**
     * Задаём фамилию и слоняем её
     *
     * @param $lastname
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function lastname($lastname,$case) {
        if(empty($lastname))
            throw new ErrorException('Lastname cannot be empty.');

        $this->lastname = $lastname;
        return $this->inflect($this->lastname,$case,__FUNCTION__);
    }

    /**
     * Функция проверяет заданное имя,фамилию или отчество на исключение
     * и склоняет
     *
     * @param $name
     * @param $case
     * @param $type
     * @return bool|string
     */
    private function inflect($name,$case,$type) {

        if(($exception = $this->checkException($name,$case,$type)) !== false)
            return $exception;

        //если двойное имя или фамилия или отчество
        if(mb_substr_count($name,'-') > 0) {
            $names_arr = explode('-',$name);
            $result = '';

            foreach($names_arr as $arr_name) {
                $result .= $this->findInRules($arr_name,$case,$type).'-';
            }
            return mb_substr($result,0,mb_strlen($result)-1);
        } else {
            return $this->findInRules($name,$case,$type);
        }
    }

    /**
     * Поиск в массиве правил
     *
     * @param $name
     * @param $case
     * @param $type
     * @return string
     */
    private function findInRules($name,$case,$type) {
        foreach($this->rules[$type]->suffixes as $rule) {
            foreach($rule->test as $last_char) {
                $last_name_char = mb_substr($name,mb_strlen($name)-mb_strlen($last_char),mb_strlen($last_char));
                if($last_char == $last_name_char) {
                    if($rule->mods[$case] == '.')
                        continue;

                    $this->setGender($rule);
                    return $this->applyRule($rule->mods,$name,$case);
                }
            }
        }
        return $name;
    }

    /**
     * Проверка на совпадение в исключениях
     *
     * @param $name
     * @param $case
     * @param $type
     * @return bool|string
     */
    private function checkException($name,$case,$type) {
        if(!isset($this->rules[$type]->exceptions))
            return false;

        $lower_name = mb_strtolower($name);

        foreach($this->rules[$type]->exceptions as $rule) {
            if(array_search($lower_name,$rule->test) !== false) {
                $this->setGender($rule);
                return $this->applyRule($rule->mods,$name,$case);
            }
        }
        return false;
    }

    /**
     * Склоняем заданное слово
     *
     * @param $mods
     * @param $name
     * @param $case
     * @return string
     */
    private function applyRule($mods,$name,$case) {
        $result = mb_substr($name,0,mb_strlen($name) - mb_substr_count($mods[$case],'-'));
        $result .= str_replace('-','',$mods[$case]);
        return $result;
    }

    private function setGender($rule) {
        if($this->gender == $this::GENDER_ANDROGYNOUS || $this->gender == null)
            switch($rule->gender) {
                case 'male': $this->gender = $this::GENDER_MALE; break;
                case 'female': $this->gender = $this::GENDER_FEMALE; break;
                case 'androgynous': $this->gender = $this::GENDER_ANDROGYNOUS; break;
        }
    }
}
