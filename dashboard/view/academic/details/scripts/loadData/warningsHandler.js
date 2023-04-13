function updateWarnings(exists6thCourse,exists7thCourse){
    if(!exists6thCourse){
        $("#no6thcoursewarning").show();
    }else{
        $("#no6thcoursewarning").hide();
    }

    if(!exists7thCourse){
        $("#no7thcoursewarning").show();
    }else{
        $("#no7thcoursewarning").hide();
    }
}