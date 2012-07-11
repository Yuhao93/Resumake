var resume = {'basicInfo':{}, 'contactInfo':{}, 'educationInfo':[], 'skillInfo':[], 'experienceInfo':[], 'activityInfo':[]};
var educationEdit = {'isEdit': false, 'index': -1, 'awards':[]};
var skillEdit = {'isEdit': false, 'index': -1, 'skills':[]};

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
			+ school + '</a></h3><p><strong>' + degree + '</strong> ' + getFormattedDate(startDate) 
			+ ' - ' + getFormattedDate(endDate) + '</p>';
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
				var name = chunks[0].replace("<p><strong>", "");
				var trailing = chunks[1].split('</p>')
				var desc = chunks[1].replace('</p>' + trailing[trailing.length - 1],"");
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