//Get the tooltip from an id, saves space in the markup
var tooltip = Array();
//basic
tooltip["label-basic-resume"] = "The name of your resume goes (e.g. My Resume, Joe's Computer Science Resume, Resume #1). This is purely for your organization only as no one else will be able to see your resume title.";
tooltip["label-basic-name"] = "This is where your name goes. You are free to change your name to anything you want, just understand that this is what anyone who looks at your resume will see first.";
tooltip["label-basic-position"] = "This is what you would introduce yourself as (e.g. Computer Science Engineer, Hobbyist, Free-Lance Painter, Environmentalist, Dragon-slayer). This should accurately summarize what you do and how you want to appear to the companies who view your resume.";
tooltip["label-basic-statement"] = "";
//contact
tooltip["label-contact-address"] = "";
tooltip["label-contact-city"] = "";
tooltip["label-contact-state"] = "";
tooltip["label-contact-zip"] = "";
tooltip["label-contact-phoneNumber"] = "";
tooltip["label-contact-email"] = "";
//education
tooltip["label-education-school"] = "";
tooltip["label-education-degree"] = "";
tooltip["label-education-startDate"] = "";
tooltip["label-education-endDate"] = "";
tooltip["label-education-award"] = "";
//skill
tooltip["label-skill-category"] = "";
tooltip["label-skill-name"] = "";
tooltip["label-skill-desc"] = "";
//experience
tooltip["label-experience-position"] = "";
tooltip["label-experience-startDate"] = "";
tooltip["label-experience-endDate"] = "";
tooltip["label-experience-group"] = "";
tooltip["label-experience-fact"] = "";
tooltip["label-experience-link-name"] = "";
tooltip["label-experience-link"] = "";
//activity
tooltip["label-activity-position"] = "";
tooltip["label-activity-startDate"] = "";
tooltip["label-activity-endDate"] = "";
tooltip["label-activity-group"] = "";
tooltip["label-activity-fact"] = "";
tooltip["label-activity-link-name"] = "";
tooltip["label-activity-link"] = "";
$('p[id^="label-"]').each(function(index){
    var id = $(this).attr("id");
    $(this).tooltip({'title':tooltip[id]});
});