//Get the tooltip from an id, saves space in the markup
var tooltip = Array();
//basic
tooltip["label-basic-resume"] = "The name of your resume goes (e.g. My Resume, Joe's Computer Science Resume, Resume #1). This is purely for your organization only as no one else will be able to see your resume title.";
tooltip["label-basic-name"] = "This is where your name goes. You are free to change your name to anything you want, just understand that this is what anyone who looks at your resume will see first.";
tooltip["label-basic-position"] = "This is what you would introduce yourself as (e.g. Computer Science Engineer, Hobbyist, Free-Lance Painter, Environmentalist, Dragon-slayer). This should accurately summarize what you do and how you want to appear to the companies who view your resume.";
tooltip["label-basic-statement"] = "This is a short one to two sentences that clearly display your intent. This is where you explicitly say what you're looking for in a job (e.g. Seeking a part-time position as a software developer. or Interested in a full-time position in a research facility).";
//contact
tooltip["label-contact-address"] = "This is your physical address. It should contain information such as your street and house/apartment number.";
tooltip["label-contact-city"] = "This is the city or town you live in.";
tooltip["label-contact-state"] = "This is for which state you live in. A user who does not live in the United States should leave it blank and place all the information in the address field.";
tooltip["label-contact-zip"] = "This is for the zipcode or area code that you live in.";
tooltip["label-contact-phoneNumber"] = "This is for your phone number. This is the phone number that you would prefer to be contacted on.";
tooltip["label-contact-email"] = "This is for your email. This is the email address that you would prefer to be contacted on.";
//education
tooltip["label-education-school"] = "This is the name of the school, institution, university or college that you attended. It should be clear enough so that anyone will be able to understand it (abbreviating it into two or three letters might not be a good idea here).";
tooltip["label-education-degree"] = "This is the degree that you earned or will earn at this school. Again, this should be fairly clear and indicative of what you have worked towards or what you are currently working towards.";
tooltip["label-education-startDate"] = "This is the date that you started at this school. This should always be filled in even if you have not started here yet. If you have yet to start at this school, place the expected start date.";
tooltip["label-education-endDate"] = "This is the date that you will have finished your education at this school. Even if this hasn't happened yet, you can put an expected finish date. In leaving it blank, the finish date will be replaced by the text \"Ongoing\".";
tooltip["label-education-award"] = "This is an award, achievement or recognition that you have earned oat the school";
//skill
tooltip["label-skill-category"] = "This is a category of your skills. It describes a set of similar skills you have.";
tooltip["label-skill-name"] = "This is a short name of your skill.";
tooltip["label-skill-desc"] = "This is a description of your skill.";
//experience
tooltip["label-experience-position"] = "This is the name of your current or most recent position for this experience. It is how you would introduce yourself. (e.g. Cashier, Data Mining Intern, Part-Time Researcher in Particle Physics, Project Manager, etc).";
tooltip["label-experience-startDate"] = "This is the date which you started. Even if you haven't started yet, you should still enter the expected start date.";
tooltip["label-experience-endDate"] = "This is the date which you stopped working with this group. If you are still working at this group, you can leave the field blank so that it will display \"Ongoing\" or you can enter your expected end date.";
tooltip["label-experience-group"] = "This is the group (company or organization) which you worked for. (e.g. Free-Lance, Target, Google, etc).";
tooltip["label-experience-fact"] = "This is a fact \"item\" for this experience. It should be a simple sentence or two. Multiple fact items give a full description of the experience.";
tooltip["label-experience-link-name"] = "This is the name of the clickable link that recruiters see.";
tooltip["label-experience-link"] = "This is the address of the web page the link leads to.";
//activity
tooltip["label-activity-position"] = "This is the name of your current or most recent position for this activity. It is how you would introduce yourself. (e.g. Treasurer, Captain, Hobbyist, Volunteer, etc.)";
tooltip["label-activity-startDate"] = "This is the date which you started. Even if you haven't started yet, you should still enter the expected start date.";
tooltip["label-activity-endDate"] = "This is the date which you left this activity. If you are still participating in this activity, you can leave the field blank so that it will display \"Ongoing\" or you can enter your expected end date.";
tooltip["label-activity-group"] = "is the group that is associated with this activity. (e.g. Boy Scouts, Student Council, GreenPeace, etc).";
tooltip["label-activity-fact"] = "This is a fact \"item\" for this activity. It should be a simple sentence or two. Multiple fact items give a full description of the activity.";
tooltip["label-activity-link-name"] = "This is the name of the clickable link that recruiters see.";
tooltip["label-activity-link"] = "This is the address of the web page the link leads to.";
$('a[id^="label"]').each(function(index){
    var id = $(this).attr("id");
    $(this).tooltip({'title':tooltip[id]});
});