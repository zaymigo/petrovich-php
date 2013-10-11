 <?php

require_once 'Petrovich.php';

trait Trait_Petrovich {

    public $middlename; //Шарыпов
    public $firstname; //Пётр
    public $lastname; //Александрович
    
	private $petrovich;

    /**
     * Задаём имя и слоняем его
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function firstname($case) {
        if (!isset($petrovich))
            $this->petrovich = new petrovich();
		
        if(empty($this->firstname))
            throw new ErrorException('Firstname cannot be empty.');

        return $this->petrovich->firstname($this->firstname,$case,__FUNCTION__);
    }

    /**
     * Задём отчество и склоняем его
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function middlename($case) {
		if (!isset($petrovich))
            $this->petrovich = new petrovich();
			
        if(empty($this->middlename))
            throw new ErrorException('Middlename cannot be empty.');

        return $this->petrovich->middlename($this->middlename,$case,__FUNCTION__);
    }

    /**
     * Задаём фамилию и слоняем её
     *
     * @param $case
     * @return bool|string
     * @throws \ErrorException
     */
    public function lastname($case) {
		if (!isset($petrovich))
            $this->petrovich = new petrovich();
	
        if(empty($this->lastname))
            throw new ErrorException('Lastname cannot be empty.');

        return $this->petrovich->lastname($this->lastname,$case,__FUNCTION__);
    }
}