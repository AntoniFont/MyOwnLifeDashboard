<?php
require_once("shouldBlockAPhoneBackend.php");
require_once("studyCriteria.php");
if (didUserStudyEnoughToday("toni",getToniStudyCriteria()) && didUserStudyEnoughToday("sufi",getSufiStudyCriteria())) {
    echo "no";
} else {
    //If yourself (sufi) didnt study enough, then block your own phone.
    //If your friend didnt study enough, block your own phone. This is a way to motivate your friend to study.
    //or otherwise he will be a bad friend and will block your phone.
    echo "yes";
}
?>