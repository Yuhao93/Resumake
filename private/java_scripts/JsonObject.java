//Copyright Yuhao Phil Ma 2012
import java.util.ArrayList;

/**
 * 
 * JsonObject keeps track of the json version of a resume
 * toString prints out the json of the resume
 * 
 * @author ypma@uci.edu (Yuhao Ma)
 */

public class JsonObject{
	//The different parts of the resume
	//We'll recursively add these parts together to build the json
	private BasicInfo basicInfo;
	private ContactInfo contactInfo;
	private ArrayList<EducationInfo> educationInfo = new ArrayList<EducationInfo>();
	private ArrayList<SkillInfo> skillInfo = new ArrayList<SkillInfo>();
	private ArrayList<ExperienceInfo> experienceInfo = new ArrayList<ExperienceInfo>();
	private ArrayList<ActivityInfo> activityInfo = new ArrayList<ActivityInfo>();
	
	//Add in the different parts
	public void addBasicInfo(String name, String position, String statement){
		basicInfo = new BasicInfo(name, position, statement);
	}
	public void addContactInfo(String address, String city, String state, String zip, String phoneNumber, String email){
		contactInfo = new ContactInfo(address, city, state, zip, phoneNumber, email);
	}
	public void addEducationInfo(String school, String degree, String startDate, String endDate, ArrayList<String> awards){
		educationInfo.add(new EducationInfo(school, degree, startDate, endDate, awards));
	}
	public void addSkillInfo(String category, ArrayList<String> skillNames, ArrayList<String> skillDescriptions){
		skillInfo.add(new SkillInfo(category, skillNames, skillDescriptions));
	}
	public void addExperienceInfo(String title, String startDate, String endDate, String group, ArrayList<ArrayList<String>> items){
		experienceInfo.add(new ExperienceInfo(title, startDate, endDate, group, items));
	}
	public void addActivityInfo(String title, String startDate, String endDate, ArrayList<ArrayList<String>> items){
		activityInfo.add(new ActivityInfo(title, startDate, endDate, items));
	}
	
	//Output Json
	public String toString(){
		String str = "{'basicInfo':" + basicInfo + ", 'contactInfo':" + contactInfo + ", 'educationInfo':[";
		for(int i = 0; i < educationInfo.size(); i++){
			str += educationInfo.get(i);
			if(i != educationInfo.size() - 1)
				str += ",";
		}
		str += "], 'skillInfo':[";
		
		for(int i = 0; i < skillInfo.size(); i++){
			str += skillInfo.get(i);
			if(i != skillInfo.size() - 1)
				str += ",";
		}
		str += "], 'experienceInfo':[";
		
		for(int i = 0; i < experienceInfo.size(); i++){
			str += experienceInfo.get(i);
			if(i != experienceInfo.size() - 1)
				str += ",";
		}
		str += "], 'activityInfo':[";
		
		for(int i = 0; i <activityInfo.size(); i++){
			str += activityInfo.get(i);
			if(i != activityInfo.size() - 1)
				str += ",";
		}
		str += "]}";
		return str;
	}
	
	//Basic Info Class
	//Json prints out the Basic Info part of the resume
	private class BasicInfo{
		private String name = "";
		private String position = "";
		private String statement = "";
		public BasicInfo(String name, String position, String statement){
			this.name = name;
			this.position = position;
			this.statement = statement;
		}
		public String toString(){
			return "{'name':'" + name + "', 'position':'" + position + "', 'statement':'" + statement + "'}";
		}
	}
	
	//Contact Info Class
	//Json prints out the Contact Info part of the resume
	private class ContactInfo{
		private String address = "";
		private String city = "";
		private String state = "";
		private String zip = "";
		private String phoneNumber = "";
		private String email = "";
		public ContactInfo(String address, 
			String city,
			String zip, 
			String state,
			String phoneNumber,
			String email){
			this.address = address;
			this.city = city;
			this.zip = zip;
			this.state = state;
			this.phoneNumber = phoneNumber;
			this.email = email;
		}
		public String toString(){
			return "{'address':'" + address + "', 'city':'" + city + "','state':'" + state + "', 'zip':'" + zip + "', 'phoneNumber':'" + phoneNumber + "', 'email':'" + email + "'}";
		}
	}
	
	//Education Info Class
	//Json prints out the Education Info part of the resume
	private class EducationInfo{
		private String school = "";
		private String degree = "";
		private String startDate = "";
		private String endDate = "";
		private ArrayList<String> awards = new ArrayList<String>();
		
		public EducationInfo(String school, String degree, String startDate, String endDate, ArrayList<String> awards){
			this.school = school;
			this.degree = degree;
			this.startDate = startDate;
			this.endDate = endDate;
			this.awards = awards;
			
		}
		public String toString(){
			String str = "{'school':'" + school + "', 'degree':'" + degree + "', 'startDate':'" + startDate + "', 'endDate':'" + endDate + "', 'awards':[";
			for(int i = 0; i < awards.size(); i++){
				str += "'" + awards.get(i) + "'";
				if(i != awards.size() - 1)
					str += ",";
			}
			str += "]}";
			return str;
		}
	}
	
	//Skill Info Class
	//Json prints out the Skill Info part of the resume
	private class SkillInfo{
		private String category;
		private ArrayList<Skill> skills = new ArrayList<Skill>();
		public SkillInfo(String category, ArrayList<String> skillNames, ArrayList<String> skillDescriptions){
			this.category = category;
			for(int i = 0; i < skillNames.size(); i++){
				skills.add(new Skill(skillNames.get(i), skillDescriptions.get(i)));
			}
		}
		public String toString(){
			String str = "{'category':'" + category + "', 'skills':[";
			for(int i = 0; i < skills.size(); i++){
				str += skills.get(i);
				if(i != skills.size() - 1)
					str += ",";
			}
			str += "]}";
			return str;
		}
		private class Skill{
			private String name = "";
			private String description = "";
			public Skill(String name, String description){
				this.name = name;
				this.description = description;
			}
			public String toString(){
				return "{'name':'" + name + "', 'description':'" + description + "'}";
			}
		}
	}
	
	//Basic Experience Class
	//Json prints out the Experience Info part of the resume
	private class ExperienceInfo{
		private String title = "";
		private String startDate = "";
		private String endDate = "";
		private String group = "";
		private ArrayList<ExperienceLine> exp = new ArrayList<ExperienceLine>();
		
		public ExperienceInfo(String title, String startDate, String endDate, String group, ArrayList<ArrayList<String>> items){
			this.title = title;
			this.startDate = startDate;
			this.endDate = endDate;
			this.group = group;
			for(int i = 0; i < items.size(); i++){
				ArrayList<String> item = items.get(i);
				String type = item.get(0);
				if(type.equals("fact")){
					exp.add(new ExperienceFact(item.get(1)));
				}else if(type.equals("link")){
					exp.add(new ExperienceLink(item.get(1), item.get(2)));
				}
			}
		}
		public String toString(){
			String str = "{'title':'" + title + "', 'startDate':'" + startDate + "', 'endDate':'" + endDate + "', 'group':'" + group + "', 'items':[";
			for(int i = 0; i < exp.size(); i++){
				str += exp.toString();
				if(i != exp.size() - 1)
					str += ",";
			}
			str += "]}";
			return str;
		}
		private abstract class ExperienceLine{}
		private class ExperienceFact extends ExperienceLine{
			private String desc = "";
			public ExperienceFact(String desc){
				this.desc = desc;
			}
			public String toString(){
				return "{'type':'fact', 'desc':'" + desc + "'}";
			}
		}
		private class ExperienceLink extends ExperienceLine{
			private String name = "";
			private String link = "";
			public ExperienceLink(String name, String link){
				this.name = name;
				this.link = link;
			}
			public String toString(){
				return "{'type':'link', 'name':'" + name + "', 'link':'" + link + "'}";
			}
		}
	}
	
	//Activity Info Class
	//Json prints out the Activity Info part of the resume
	//Exact same as ExperienceInfo!
	private class ActivityInfo{
		private String title = "";
		private String startDate = "";
		private String endDate = "";
		private ArrayList<ActivityLine> exp = new ArrayList<ActivityLine>();
		
		public ActivityInfo(String title, String startDate, String endDate, ArrayList<ArrayList<String>> items){
			this.title = title;
			this.startDate = startDate;
			this.endDate = endDate;
			for(int i = 0; i < items.size(); i++){
				ArrayList<String> item = items.get(i);
				String type = item.get(0);
				if(type.equals("fact")){
					exp.add(new ActivityFact(item.get(1)));
				}else if(type.equals("link")){
					exp.add(new ActivityLink(item.get(1), item.get(2)));
				}
				
			}
		}
		public String toString(){
			String str = "{'title':'" + title + "', 'startDate':'" + startDate + "', 'endDate':'" + endDate + "', 'items':[";
			for(int i = 0; i < exp.size(); i++){
				str += exp.toString();
				if(i != exp.size() - 1)
					str += ",";
			}
			str += "]}";
			return str;
		}
		private abstract class ActivityLine{}
		private class ActivityFact extends ActivityLine{
			private String desc = "";
			public ActivityFact(String desc){
				this.desc = desc;
			}
			public String toString(){
				return "{'type':'fact', 'desc':'" + desc + "'}";
			}
		}
		private class ActivityLink extends ActivityLine{
			private String name = "";
			private String link = "";
			public ActivityLink(String name, String link){
				this.name = name;
				this.link = link;
			}
			public String toString(){
				return "{'type':'link', 'name':'" + name + "', 'link':'" + link + "'}";
			}
		}
	}
	
	
}