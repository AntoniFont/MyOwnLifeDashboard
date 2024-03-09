<?php 
/*For the future this should be in a database */
class StudyCriteria{
    private $studyBaselineByDays; 
    //An array of 7 elements, each element is the amount of minutes that the user should study on that day
    //For example [90,90,50,50,90,90,90] would mean that the user should study 90 minutes on Sunday, 90 minutes on Monday, 50 minutes on Tuesday, 50 minutes on Wednesday, 90 minutes on Thursday, 90 minutes on Friday and 90 minutes on Saturday
    //The value -1 means that the user does not have to study that day
    private $cotoutMinute; //The time in minutes when the phone should be blocked if the user has not studied enough
    //for example 11:22 would be 11*60+22

    private $progressiveBlock;  //This feature is not implemented yet.

    private $exceptionDay; //For example "2024-03-04" for the 04 of March of 2024

    public function __construct($studyBaselineByDays, $cotoutMinute,$exceptionDay ,$progressiveBlock = false){
        $this->studyBaselineByDays = $studyBaselineByDays;
        $this->cotoutMinute = $cotoutMinute;
        $this->exceptionDay = $exceptionDay;
        $this->progressiveBlock = $progressiveBlock;
    }

    public function getStudyBaselineByDays(){
        return $this->studyBaselineByDays;
    }

    public function getCotoutMinute(){
        return $this->cotoutMinute;
    }

    public function getFormattedCotoutMinuteString(){ //682 would be "11:22:00"
        $hours = floor($this->cotoutMinute / 60);
        $minutes = $this->cotoutMinute % 60;
        return $hours.":".$minutes.":00";
    }

    public function getExceptionDay(){
        return $this->exceptionDay;
    }

    public function getProgressiveBlock(){
        return $this->progressiveBlock;
    }

    public function getAverageDailyBaseline(){
        $sum = 0;
        for($i = 0; $i < count($this->studyBaselineByDays); $i++){
            $sum += $this->studyBaselineByDays[$i];
        }
        return $sum/7;
    }


}


function getSufiStudyCriteria(){
    return new StudyCriteria(
        [
            90, //You should study this minutes on Sunday
            90, //You should study this minutes on Monday
            50, //You should study this minutes on Tuesday
            50, //You should study this minutes on Wednesday
            90, //You should study this minutes on Thursday
            90, //You should study this minutes on Friday
            90  //You should study this minutes on Saturday
        ],
        "2024-03-03", //Exception day
        18*60+0 //18:00
    );

}

function getToniStudyCriteria(){
    return new StudyCriteria(
        [
            90, //You should study this minutes on Sunday
            90, //You should study this minutes on Monday
            50, //You should study this minutes on Tuesday
            50, //You should study this minutes on Wednesday
            90, //You should study this minutes on Thursday
            90, //You should study this minutes on Friday
            90  //You should study this minutes on Saturday
        ],
        "2024-03-04", //Exception day
        11*60+22 //11:22
    );
}

?>