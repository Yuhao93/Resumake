var resume = {'basicInfo':{}, 'contactInfo':{}, 'educationInfo':[], 'skillInfo':[], 'experienceInfo':[], 'activityInfo':[]};
var educationEdit = {'isEdit' : false, 'index' : -1, 'awards' : []};
var skillEdit = {'isEdit' : false, 'index': -1, 'skills' : []};
var experienceEdit = {'isEdit' : false, 'index' : -1, 'items' : []};
var activityEdit = {'isEdit' : false, 'index' : -1, 'items' : []};

//==================================================================================================
//==========================================Education Info==========================================
//==================================================================================================
function addAward(){
	var index = educationEdit.awards.length;
	var award = $("#education-award-name").attr("value");
	$("#education-award-name").attr("value", "");
	$("#education-award-list").html("");
	
	educationEdit.awards[index] = award;
	repopulateAwards();
}
function repopulateAwards(){
	$("#education-award-list").html("");
	for(var i = 0; i < educationEdit.awards.length; i++){
		var award = educationEdit.awards[i];
		$("#education-award-list").append('<li class="span3 education-award" id="award-' + i + '">'+ award +
			'<button class="close pull-right" id="award-' + i + '">x</button></li>');
		$("button#award-" + i).click(function(){
			var id = $(this).attr("id").substring(6);
			$("li#award-" + id).remove();
			educationEdit.awards = [];
			$("li.education-award").each(function(index){
				var text = $(this).text();
				educationEdit.awards.push(text.substring(0, text.length - 1));
			});
		});
	}
}
function saveEducation(){
	// If we are editing an existing one, modify that one
	// Then refresh the container
	if(educationEdit.isEdit){
		// Get the data from the form
		var school = "" + $("#education-school").attr("value");
		var degree = "" + $("#education-degree").attr("value");
		var startDate = "" + $("#education-startDate").attr("value");
		var endDate = "" + $("#education-endDate").attr("value");
		var awards = new Array();
		$(".education-award").each(function(index){
			var text = $(this).text()
			awards.push(text.substring(0, text.length - 1));
		});
	
		// Clear the data 
		$("#education-school").attr("value", "");
		$("#education-degree").attr("value", "");
		$("#education-startDate").attr("value", "");
		$("#education-endDate").attr("value", "");
		$("#education-award-list").html("");
		
		// Revalidate the screen and update the info
		resume.educationInfo[educationEdit.index] = {'school':school, 'degree':degree, 'startDate':startDate, 'endDate':endDate, 'awards':awards};
		revalidateEducationField();
	}
	// If we are adding a new one, push it to the end
	// Then refresh the container
	else{
		// Get the data from the form
		var school = "" + $("#education-school").attr("value");
		var degree = "" + $("#education-degree").attr("value");
		var startDate = "" + $("#education-startDate").attr("value");
		var endDate = "" + $("#education-endDate").attr("value");
		var awards = new Array();
		$(".education-award").each(function(index){
			var text = $(this).text()
			awards.push(text.substring(0, text.length - 1));
		});
	
		// Clear the data 
		$("#education-school").attr("value", "");
		$("#education-degree").attr("value", "");
		$("#education-startDate").attr("value", "");
		$("#education-endDate").attr("value", "");
		$("#education-award-list").html("");
	
		// Revalidate the screen and update the info
		resume.educationInfo.push({'school':school, 'degree':degree, 'startDate':startDate, 'endDate':endDate, 'awards':awards});
		revalidateEducationField();
	}
}
function revalidateEducationField(){
	// Clear the content
	$("#education-container").html("");
	for(var i = 0; i < resume.educationInfo.length; i++){
		// Get the information of this education field
		var school = resume.educationInfo[i].school;
		var degree = resume.educationInfo[i].degree;
		var startDate = resume.educationInfo[i].startDate;
		var endDate = resume.educationInfo[i].endDate;
		var awards = resume.educationInfo[i].awards;
		
		// Generate the markup given the information
		var appendableText = '<div class="education-object" id = "edu-obj-' + i + '"><a class="close" id="education-delete-' + i + '">X</a>' 
			+ '<h3><a class="education-edit-link" id="education-edit-' + i + '" href="#education-modal" data-toggle="modal">' 
			+ school + '</a></h3><p><strong>' + degree + '</strong> ' + getFullFormatDate(startDate, endDate) + '</p>';
		for(var j = 0; j < awards.length; j ++)
			appendableText += '<p><strong>' + awards[j] + '</strong></p>';
		appendableText += '</div>';
		
		// Add the markup to the container
		$("#education-container").append(appendableText);
		
		//Register the events
		$("#education-edit-" + i).click(function(){
			var id = $(this).attr("id");
			var index = id.substring(15);
			editEducation(index);
		});
		$("#education-delete-" + i).click(function(){
			var index = $(this).attr("id").substring(17);
			resume.educationInfo.splice(index, 1);
			$("#edu-obj-" + index).remove();
		});
	}
}
function editEducation(index){
	educationEdit.isEdit = true;
	educationEdit.index = index;
	educationEdit.awards = resume.educationInfo[index].awards;
	
	// Get the current information
	var school = resume.educationInfo[index].school;
	var degree = resume.educationInfo[index].degree;
	var startDate = resume.educationInfo[index].startDate;
	var endDate = resume.educationInfo[index].endDate;
	
	$("#education-school").attr("value", school);
	$("#education-degree").attr("value", degree);
	$("#education-startDate").attr("value", startDate);
	$("#education-endDate").attr("value", endDate);
	repopulateAwards();
}

//==================================================================================================
//============================================Skill Info============================================
//==================================================================================================
function addSkill(){
	var index = skillEdit.skills.length;
	var skillName = $("#skill-name").attr("value");
	var skillDesc = $("#skill-desc").attr("value");
	$("#skill-name").attr("value", "");
	$("#skill-desc").attr("value", "");
	$("#skill-list").html("");
	
	skillEdit.skills[index] = {'name' : skillName, 'desc' : skillDesc};
	repopulateSkills();
}
function repopulateSkills(){
	$("#skill-list").html("");
	for(var i = 0; i < skillEdit.skills.length; i++){
		var skill = skillEdit.skills[i];
		$("#skill-list").append('<li class="span3 skill-item" id="skill-' + i + '"><button class="close pull-right" id="skill-' + i + '">x</button><p><strong>'
			+ skill.name + '</strong></p><p>' + skill.desc + 
			'</p></li>');
		$("button#skill-" + i).click(function(){
			var id = $(this).attr("id").substring(6);
			$("li#skill-" + id).remove();
			skillEdit.skills = [];
			$("li.skill-item").each(function(index){
				var innerHtml = $(this).html();
				var chunks = innerHtml.split("</strong></p><p>");
				var head = chunks[0].split('<strong>');
				var name = head[head.length - 1];
				var desc = chunks[1].replace('</p></li>',"");
				skillEdit.skills.push({'name' : name, 'desc' : desc});
			});
		});
	}
}
function saveSkillCategory(){
	// If we are editing an existing one, modify that one
	// Then refresh the container
	if(skillEdit.isEdit){
		// Get the data from the form
		var category = "" + $("#skill-category").attr("value");
		var skills = skillEdit.skills;
	
		// Clear the data 
		$("#skill-category").attr("value", "");
		$("#skill-list").html("");
		
		// Revalidate the screen and update the info
		resume.skillInfo[skillEdit.index] = {'category':category, 'skills':skills};
		revalidateSkillField();
	}
	// If we are adding a new one, push it to the end
	// Then refresh the container
	else{
		// Get the data from the form
		var category = "" + $("#skill-category").attr("value");
		var skills = skillEdit.skills;
	
		// Clear the data 
		$("#skill-category").attr("value", "");
		$("#skill-list").html("");
	
		// Revalidate the screen and update the info
		resume.skillInfo.push({'category':category, 'skills':skills});
		revalidateSkillField();
	}
}
function revalidateSkillField(){
	// Clear the content
	$("#skill-container").html("");
	for(var i = 0; i < resume.skillInfo.length; i++){
		// Get the information of this skill field
		var category = resume.skillInfo[i].category;
		var skills = resume.skillInfo[i].skills;
		
		// Generate the markup given the information
		var appendableText = '<div class="skill-object" id = "skill-object-' + i + '"><a class="close" id="skill-delete-' + i + '">X</a>' 
			+ '<h3><a class="skill-edit-link" id="skill-edit-' + i + '" href="#skill-modal" data-toggle="modal">' 
			+ category + '</a></h3>';
		for(var j = 0; j < skills.length; j ++)
			appendableText += '<p><strong>' + skills[j].name + '</strong> - ' + skills[j].desc + '</p>';
		appendableText += '</div>';
		
		// Add the markup to the container
		$("#skill-container").append(appendableText);
		
		//Register the events
		$("#skill-edit-" + i).click(function(){
			var id = $(this).attr("id");
			var index = id.substring(11);
			editSkill(index);
		});
		$("#skill-delete-" + i).click(function(){
			var index = $(this).attr("id").substring(13);
			var removed = resume.skillInfo.splice(index, 1);
			revalidateSkillField();
		});
	}
}
function editSkill(index){
	skillEdit.isEdit = true;
	skillEdit.index = index;
	skillEdit.skills = resume.skillInfo[index].skills;
	
	// Get the current information
	var category = resume.skillInfo[index].category;
	
	$("#skill-category").attr("value", category);
	repopulateSkills();
}

//==================================================================================================
//============================================Experience Info=======================================
//==================================================================================================
function addLinkExperience(){
	var index = experienceEdit.items.length;
	var linkName = $("#experience-link-name").attr("value");
	var link = $("#experience-link").attr("value");
	$("#experience-link-name").attr("value", "");
	$("#experience-link").attr("value", "");
	$("#experience-item-list").html("");
	
	experienceEdit.items[index] = {'type':'link', 'name':linkName, 'link':link};
	repopulateExperienceItems();
}
function addDescExperience(){
	var index = experienceEdit.items.length;
	var desc = $("#experience-desc").attr("value");
	$("#experience-desc").attr("value", "");
	$("#experience-item-list").html("");
	
	experienceEdit.items[index] = {'type':'desc', 'desc':desc};
	repopulateExperienceItems();
}
function repopulateExperienceItems(){
	$("#experience-item-list").html("");
	for(var i = 0; i < experienceEdit.items.length; i++){
		var item = experienceEdit.items[i];
		var content = item.type == "desc" ? 
			"<p><strong>" + item.desc + "</strong></p>" : 
			"<a href=\"" + item.link + "\" target=\"_blank\">" + item.name + "</a>"; 
		
		$("#experience-item-list").append('<li class="span3 experience-item" id="experience-' + i + '">'
			+ '<button class="close pull-right" id="experience-' + i + '">x</button>'
			+ content + 
			'</li>');
		$("button#experience-" + i).click(function(){
			var id = $(this).attr("id").substring(11);
			$("li#experience-" + id).remove();
			experienceEdit.items = [];
			
			$("li.experience-item").each(function(index){
				var innerHtml = $(this).html();
				var beginStr = innerHtml.replace(innerHtml.split("</button>")[0] + "</button>", "");
				if(beginStr.indexOf("<p><strong>") == 0){
					var desc = beginStr.substring(11, beginStr.length - 13);
					experienceEdit.items.push({'type':'desc', 'desc':desc});
				}else if(beginStr.indexOf("<a href=\"") == 0){
					var beginLength = ("<a href=\"").length;
					var middleInd = beginStr.indexOf("\" target=\"_blank\">");
					var middleEnd = middleInd + ("\" target=\"_blank\">").length;
					var endInd = beginStr.length - 4;
					var name = beginStr.substring(middleEnd, endInd);
					var link = beginStr.substring(beginLength, middleInd);
					
					experienceEdit.items.push({'type':'link', 'name':name, 'link':link});
				}
			});
		});
	}
}
function saveExperienceCategory(){
	// If we are editing an existing one, modify that one
	// Then refresh the container
	if(experienceEdit.isEdit){
		// Get the data from the form
		var position = "" + $("#experience-position").attr("value");
		var startDate = "" + $("#experience-start-date").attr("value");
		var endDate = "" + $("#experience-end-date").attr("value");
		var group = "" + $("#experience-group").attr("value");
		
		var items = experienceEdit.items;
	
		// Clear the data 
		$("#experience-position").attr("value", "");
		$("#experience-start-date").attr("value", "");
		$("#experience-end-date").attr("value", "");
		$("#experience-group").attr("value", "");
		$("#experience-item-list").html("");
		
		// Revalidate the screen and update the info
		resume.experienceInfo[experienceEdit.index] = {'position':position, 'startDate':startDate, 'endDate':endDate, 'group':group, 'items': items};
		revalidateExperienceField();
	}
	// If we are adding a new one, push it to the end
	// Then refresh the container
	else{
		// Get the data from the form
		var position = "" + $("#experience-position").attr("value");
		var startDate = "" + $("#experience-start-date").attr("value");
		var endDate = "" + $("#experience-end-date").attr("value");
		var group = "" + $("#experience-group").attr("value");
		
		var items = experienceEdit.items;
	
		// Clear the data 
		$("#experience-position").attr("value", "");
		$("#experience-start-date").attr("value", "");
		$("#experience-end-date").attr("value", "");
		$("#experience-group").attr("value", "");
		$("#experience-item-list").html("");
		
		// Revalidate the screen and update the info
		resume.experienceInfo.push({'position':position, 'startDate':startDate, 'endDate':endDate, 'group':group, 'items': items});
		revalidateExperienceField();
	}
}
function revalidateExperienceField(){
	// Clear the content
	$("#experience-container").html("");
	for(var i = 0; i < resume.experienceInfo.length; i++){
		// Get the information of this experience field
		var position = resume.experienceInfo[i].position;
		var startDate = resume.experienceInfo[i].startDate;
		var endDate = resume.experienceInfo[i].endDate;
		var group = resume.experienceInfo[i].group;
		
		var items = resume.experienceInfo[i].items;
		
		// Generate the markup given the information
		var appendableText = '<div class="experience-object" id = "experience-object-' + i + '"><a class="close" id="experience-delete-' + i + '">X</a>' 
			+ '<h3><a class="experience-edit-link" id="experience-edit-' + i + '" href="#experience-modal" data-toggle="modal">' 
			+ position + '</a></h3><h3>' + group + ' ' + getFullFormatDate(startDate, endDate) + '</h3>';
		for(var j = 0; j < items.length; j ++){
			if(items[j].type == "link")
				appendableText += '<a href="' + items[j].link + '" target="_blank">' + items[j].name + '</a>';
			else if(items[j].type == "desc")
				appendableText += '<p><strong>' + items[j].desc + '</strong></p>';
		}
		appendableText += '</div>';
		
		// Add the markup to the container
		$("#experience-container").append(appendableText);
		
		//Register the events
		$("#experience-edit-" + i).click(function(){
			var id = $(this).attr("id");
			var index = id.substring(16);
			editExperience(index);
		});
		$("#experience-delete-" + i).click(function(){
			var index = $(this).attr("id").substring(18);
			var removed = resume.experienceInfo.splice(index, 1);
			revalidateExperienceField();
		});
	}
}
function editExperience(index){
	experienceEdit.isEdit = true;
	experienceEdit.index = index;
	experienceEdit.items = resume.experienceInfo[index].items;
	
	// Get the current information
	var position = resume.experienceInfo[index].position;
	var startDate = resume.experienceInfo[index].startDate;
	var endDate = resume.experienceInfo[index].endDate;
	var group = resume.experienceInfo[index].group;
	
	$("#experience-position").attr("value", position);
	$("#experience-start-date").attr("value", startDate);
	$("#experience-end-date").attr("value", endDate);
	$("#experience-group").attr("value", group);
	
	repopulateExperienceItems();
}

//==================================================================================================
//============================================Activity Info=========================================
//==================================================================================================
function addLinkActivity(){
	var index = activityEdit.items.length;
	var linkName = $("#activity-link-name").attr("value");
	var link = $("#activity-link").attr("value");
	$("#activity-link-name").attr("value", "");
	$("#activity-link").attr("value", "");
	$("#activity-item-list").html("");
	
	activityEdit.items[index] = {'type':'link', 'name':linkName, 'link':link};
	repopulateActivityItems();
}
function addDescActivity(){
	var index = activityEdit.items.length;
	var desc = $("#activity-desc").attr("value");
	$("#activity-desc").attr("value", "");
	$("#activity-item-list").html("");
	
	activityEdit.items[index] = {'type':'desc', 'desc':desc};
	repopulateActivityItems();
}
function repopulateActivityItems(){
	$("#activity-item-list").html("");
	for(var i = 0; i < activityEdit.items.length; i++){
		var item = activityEdit.items[i];
		var content = item.type == "desc" ? 
			"<p><strong>" + item.desc + "</strong></p>" : 
			"<a href=\"" + item.link + "\" target=\"_blank\">" + item.name + "</a>"; 
		
		$("#activity-item-list").append('<li class="span3 activity-item" id="activity-' + i + '">'
			+ '<button class="close pull-right" id="activity-' + i + '">x</button>'
			+ content + 
			'</li>');
		$("button#activity-" + i).click(function(){
			var id = $(this).attr("id").substring(11);
			$("li#activity-" + id).remove();
			activityEdit.items = [];
			
			$("li.activity-item").each(function(index){
				var innerHtml = $(this).html();
				var beginStr = innerHtml.replace(innerHtml.split("</button>")[0] + "</button>", "");
				if(beginStr.indexOf("<p><strong>") == 0){
					var desc = beginStr.substring(11, beginStr.length - 13);
					activityEdit.items.push({'type':'desc', 'desc':desc});
				}else if(beginStr.indexOf("<a href=\"") == 0){
					var beginLength = ("<a href=\"").length;
					var middleInd = beginStr.indexOf("\" target=\"_blank\">");
					var middleEnd = middleInd + ("\" target=\"_blank\">").length;
					var endInd = beginStr.length - 4;
					var name = beginStr.substring(middleEnd, endInd);
					var link = beginStr.substring(beginLength, middleInd);
					
					activityEdit.items.push({'type':'link', 'name':name, 'link':link});
				}
			});
		});
	}
}
function saveActivityCategory(){
	// If we are editing an existing one, modify that one
	// Then refresh the container
	if(activityEdit.isEdit){
		// Get the data from the form
		var position = "" + $("#activity-position").attr("value");
		var startDate = "" + $("#activity-start-date").attr("value");
		var endDate = "" + $("#activity-end-date").attr("value");
		var group = "" + $("#activity-group").attr("value");
		
		var items = activityEdit.items;
	
		// Clear the data 
		$("#activity-position").attr("value", "");
		$("#activity-start-date").attr("value", "");
		$("#activity-end-date").attr("value", "");
		$("#activity-group").attr("value", "");
		$("#activity-item-list").html("");
		
		// Revalidate the screen and update the info
		resume.activityInfo[activityEdit.index] = {'position':position, 'startDate':startDate, 'endDate':endDate, 'group':group, 'items': items};
		revalidateActivityField();
	}
	// If we are adding a new one, push it to the end
	// Then refresh the container
	else{
		// Get the data from the form
		var position = "" + $("#activity-position").attr("value");
		var startDate = "" + $("#activity-start-date").attr("value");
		var endDate = "" + $("#activity-end-date").attr("value");
		var group = "" + $("#activity-group").attr("value");
		
		var items = activityEdit.items;
	
		// Clear the data 
		$("#activity-position").attr("value", "");
		$("#activity-start-date").attr("value", "");
		$("#activity-end-date").attr("value", "");
		$("#activity-group").attr("value", "");
		$("#activity-item-list").html("");
		
		// Revalidate the screen and update the info
		resume.activityInfo.push({'position':position, 'startDate':startDate, 'endDate':endDate, 'group':group, 'items': items});
		revalidateActivityField();
	}
}
function revalidateActivityField(){
	// Clear the content
	$("#activity-container").html("");
	for(var i = 0; i < resume.activityInfo.length; i++){
		// Get the information of this activity field
		var position = resume.activityInfo[i].position;
		var startDate = resume.activityInfo[i].startDate;
		var endDate = resume.activityInfo[i].endDate;
		var group = resume.activityInfo[i].group;
		
		var items = resume.activityInfo[i].items;
		
		// Generate the markup given the information
		var appendableText = '<div class="activity-object" id = "activity-object-' + i + '"><a class="close" id="activity-delete-' + i + '">X</a>' 
			+ '<h3><a class="activity-edit-link" id="activity-edit-' + i + '" href="#activity-modal" data-toggle="modal">' 
			+ position + '</a></h3><h3>' + group + ' ' + getFullFormatDate(startDate, endDate) + '</h3>';
		for(var j = 0; j < items.length; j ++){
			if(items[j].type == "link")
				appendableText += '<a href="' + items[j].link + '" target="_blank">' + items[j].name + '</a>';
			else if(items[j].type == "desc")
				appendableText += '<p><strong>' + items[j].desc + '</strong></p>';
		}
		appendableText += '</div>';
		
		// Add the markup to the container
		$("#activity-container").append(appendableText);
		
		//Register the events
		$("#activity-edit-" + i).click(function(){
			var id = $(this).attr("id");
			var index = id.substring(16);
			editActivity(index);
		});
		$("#activity-delete-" + i).click(function(){
			var index = $(this).attr("id").substring(18);
			var removed = resume.activityInfo.splice(index, 1);
			revalidateActivityField();
		});
	}
}
function editActivity(index){
	activityEdit.isEdit = true;
	activityEdit.index = index;
	activityEdit.items = resume.activityInfo[index].items;
	
	// Get the current information
	var position = resume.activityInfo[index].position;
	var startDate = resume.activityInfo[index].startDate;
	var endDate = resume.activityInfo[index].endDate;
	var group = resume.activityInfo[index].group;
	
	$("#activity-position").attr("value", position);
	$("#activity-start-date").attr("value", startDate);
	$("#activity-end-date").attr("value", endDate);
	$("#activity-group").attr("value", group);
	
	repopulateActivityItems();
}

//Given a date, return the formatted date Month Year
function getFormattedDate(date){
	var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	if(date == undefined || date.indexOf("-") == -1)
		return "";
	var year = date.split("-")[0];
	var num = date.split("-")[1];
	if(num.charAt(0) == '0')
		num = num.substring(1);
	var m = month[parseInt(num) - 1];
	return m + " " + year;
}

function getFullFormatDate(startDate, endDate){
    if(getFormattedDate(endDate) == ""){
        if(getFormattedDate(startDate) != ""){
            return getFormattedDate(startDate) + " - Ongoing";
        }else{
            return "";
        }
    }else{
        if(getFormattedDate(startDate) == "")
            return " Until " + getFormattedDate(endDate);
        else
            return getFormattedDate(startDate) + " - " + getFormattedDate(endDate);
    }
}

$(document).ready(function(){
	$("#education-award-add").click(function(){
		addAward();
	});
	$("#education-save").click(function(){
		saveEducation();
	});
	$("#add-education-btn").click(function(){
		if(educationEdit.isEdit){
			$("#skill-category").attr("value", "");
			$("#skill-list").html("");
		}
		educationEdit.isEdit = false;
		educationEdit.awards = [];
	});
	
	$("#skill-add").click(function(){
		addSkill();
	});
	$("#skill-save").click(function(){
		saveSkillCategory();
	});
	$("#add-skill-btn").click(function(){
		skillEdit.isEdit = false;
		skillEdit.skills = [];
	});
	
	$("#experience-fact-add").click(function(){
		addDescExperience();
	});
	
	$("#experience-link-add").click(function(){
		addLinkExperience();
	});
	$("#experience-save").click(function(){
		saveExperienceCategory();
	});
	$("#btn-add-experience").click(function(){
		experienceEdit.isEdit = false;
		experienceEdit.items = [];
	});
	
	$("#activity-fact-add").click(function(){
		addDescActivity();
	});
		
	$("#activity-link-add").click(function(){
		addLinkActivity();
	});
	$("#activity-save").click(function(){
		saveActivityCategory();
	});
	$("#btn-add-activity").click(function(){
		activityEdit.isEdit = false;
		activityEdit.items = [];
	});
	
    $("#code-preview").click(function(){
        completeResume();
        var name = $("#basic-resume").attr("value");
		$.post("../resumepreview/index.php", {'content': JSON.stringify(resume)}, function(data){
            var previewWindow = window.open('', '_blank');
            previewWindow.document.writeln(data);
        });
    });
    
	$("#code-submit").click(function(){
        completeResume();
		var name = $("#basic-resume").attr("value");
		$.post('../private/php_scripts/addResume.php', {'uid':uid, 'resume':resume, 'name':name}, function(data){
            window.location.href = "../users/" + username;
		});
	});
});

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
        "email":$("#contact-email").attr("value")
    };
}