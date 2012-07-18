function completeResume(){
    resume.basicInfo = {
        "name":$("#basic-name").attr("value"), 
        "position":$("#basic-position").attr("value"), 
        "statement":$("#basic-statement").attr("value")
    };
    resume.contactInfo = {
        "address":$("#contact-address").attr("value"),
        "city":$("#contact-city").attr("value"),
        "state":$("#contact-state").attr("value"),
        "zip":$("#contact-zip").attr("value"),
        "phoneNumber":$("#contact-phone").attr("value"),
        "email":$("#contact-email").attr("value"),
    };
}