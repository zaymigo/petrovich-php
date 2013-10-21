 <?php

require_once 'Petrovich.php';

trait Trait_Petrovich {

    public $firstname; // Александр
    public $middlename; // Сергеевич
    public $lastname; // Пушкин
    
	private $petrovich;

    private $gender = Petrovich::GENDER_ANDROGYNOUS;

    /**
     * Задаём имя и слоняем его
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function firstname($case = Petrovich::CASE_NOMENATIVE) {
        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $this->firstname;
        }

        if (!isset($petrovich))
            $this->petrovich = new Petrovich();

        return $this->petrovich->firstname($this->firstname,$case,__FUNCTION__);
    }

    /**
     * Задём отчество и склоняем его
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function middlename($case = Petrovich::CASE_NOMENATIVE) {
        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $this->middlename;
        }

		if (!isset($petrovich))
            $this->petrovich = new Petrovich();

        return $this->petrovich->middlename($this->middlename,$case,__FUNCTION__);
    }

    /**
     * Задаём фамилию и слоняем её
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function lastname($case = Petrovich::CASE_NOMENATIVE) {
        if ($case === Petrovich::CASE_NOMENATIVE) {
            return $this->firstname;
        }

		if (!isset($petrovich))
            $this->petrovich = new Petrovich();

        return $this->petrovich->lastname($this->lastname,$case,__FUNCTION__);
    }

    /**
     * Возвращает пол на основе последнего запроса
     *
     * @return integer
     */
    public function gender() {
        if (!isset($petrovich))
            $this->petrovich = new Petrovich();

        $this->gender = $this->petrovich->gender;

        return $this->gender;
    }
}
