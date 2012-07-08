//Copyright Yuhao Ma 2012
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.HashMap;

/**
 * Text parser for turning resumake format text into json string
 * 
 * @author ypma@uci.edu (Yuhao Ma)
 */

public class Parser{
	//Object to keep track of all the the data
	private static JsonObject json = new JsonObject();
	
	//Array of lines
	private static ArrayList<String> lines = new ArrayList<String>();
	
	
	public static void main(String[] args) throws Exception{
		String fileName = args[0];
		BufferedReader br = new BufferedReader(new FileReader("../../rmks/" + fileName));
		PrintWriter pw = new PrintWriter("out.txt");
		pw.println(parse(br));
		br.close();
		pw.flush();
		pw.close();
	}
	
	//Parse, given a buffered reader of the file
	public static String parse(BufferedReader br) throws Exception{
		//write all lines into the arraylist
		String ln = br.readLine();
		while(ln != null){
			lines.add(ln);
			ln = br.readLine();
		}
	
		//parse for all the different types of info
		parseBasicInfo();
		parseContactInfo();
		parseEducationInfo();
		parseSkillInfo();
		parseExperienceInfo();
		parseActivityInfo();
		
		//output the string
		return json.toString();
	}
	
	//get the basic info
	private static void parseBasicInfo(){
		String name = getStringFromTag("Name");
		String position = getStringFromTag("Position");
		String statement = getStringFromTag("Statement");
		json.addBasicInfo(name, position, statement);
	}
	
	//get the contact info
	private static void parseContactInfo(){
		String address = getStringFromTag("Address");
		String city = getStringFromTag("City");
		String state = getStringFromTag("State");
		String zip = getStringFromTag("Zip");
		String phoneNumber = getStringFromTag("Phone-Number");
		String email = getStringFromTag("Email");
		json.addContactInfo(address, city, state, zip, phoneNumber, email);
	}
	
	//get the education info
	private static void parseEducationInfo(){
		int index = getTagLocation("School", 0);
		while(index != -1){
			ArrayList<String> awards = new ArrayList<String>();
			int awardIndex = getTagLocation("Award", index);
			String school = getStringFromLine(index);
			String degree = getStringFromTag("Degree", index);
			String startDate = getStringFromTag("Start-Date", index);
			String endDate = getStringFromTag("End-Date", index);
			
			index = getTagLocation("School", index + 1);
			while((awardIndex != -1 && awardIndex < index && index != -1) || (awardIndex != -1 && index == -1)){
				awards.add(getStringFromLine(awardIndex));
				awardIndex = getTagLocation("Award", awardIndex + 1);
			}
			json.addEducationInfo(school, degree, startDate, endDate, awards);
		}
	}
	
	//get the skill info
	private static void parseSkillInfo(){
		HashMap<String, ArrayList<String>> names = new HashMap<String, ArrayList<String>>();
		HashMap<String, ArrayList<String>> descs = new HashMap<String, ArrayList<String>>();
		int index = getTagLocation("Skill-Category", 0);
		while(index != -1){
			String category = getStringFromLine(index);
			ArrayList<String> nameList;
			ArrayList<String> descList;
			if(names.containsKey(category)){
				nameList = names.get(category);
				descList = descs.get(category);
			}else{
				nameList = new ArrayList<String>();
				descList = new ArrayList<String>();
			}
			String name = getStringFromTag("Skill-Name", index);
			String desc = getStringFromTag("Skill-Description", index);
			nameList.add(name);
			descList.add(desc);
			names.put(category, nameList);
			descs.put(category, descList);
			index = getTagLocation("Skill-Category", index + 1);
		}
		for(String key : names.keySet()){
			json.addSkillInfo(key, names.get(key), descs.get(key));
		}
	}
	
	//get the experience info
	private static void parseExperienceInfo(){
		int index = getTagLocation("Experience-Title", 0);
		while(index != -1){
			String title = getStringFromLine(index);
			String startDate = "";
			String endDate = "";
			String group = "";
			ArrayList<ArrayList<String>> items = new ArrayList<ArrayList<String>>();
			int nextIndex = getTagLocation("Experience-Title", index+1);
			int len = 0;
			if(nextIndex != -1){
				len = nextIndex;
			}else{
				len = lines.size();
			}
			for(int i = index; i < len; i++){
				String ln = lines.get(i);
				if(ln.length() != 0 && ln.charAt(0) != '#'){
					String tag = ln.split(":")[0];
					if(tag.equals("Experience-Start-Date"))
						startDate = getStringFromLine(i);
					if(tag.equals("Experience-End-Date"))
						endDate = getStringFromLine(i);
					if(tag.equals("Experience-Group"))
						group = getStringFromLine(i);
					if(tag.equals("Experience-Fact")){
						ArrayList<String> item = new ArrayList<String>();
						item.add("fact");
						item.add(getStringFromLine(i));
						items.add(item);
					}
					if(tag.equals("Experience-Link-Name")){
						ArrayList<String> item = new ArrayList<String>();
						item.add("link");
						item.add(getStringFromLine(i));
						item.add(getStringFromLine(i + 1));
						items.add(item);
					}
				}
			}
			json.addExperienceInfo(title, startDate, endDate, group, items);
			index = nextIndex;
		}
	}
	
	//get the activity info
	private static void parseActivityInfo(){
		int index = getTagLocation("Activity-Title", 0);
		while(index != -1){
			String title = getStringFromLine(index);
			String startDate = "";
			String endDate = "";
			ArrayList<ArrayList<String>> items = new ArrayList<ArrayList<String>>();
			int nextIndex = getTagLocation("Activity-Title", index+1);
			int len = 0;
			if(nextIndex != -1){
				len = nextIndex;
			}else{
				len = lines.size();
			}
			for(int i = index; i < len; i++){
				String ln = lines.get(i);
				if(ln.length() != 0 && ln.charAt(0) != '#'){
					String tag = ln.split(":")[0];
					if(tag.equals("Activity-Start-Date"))
						startDate = getStringFromLine(i);
					if(tag.equals("Activity-End-Date"))
						endDate = getStringFromLine(i);
					if(tag.equals("Activity-Fact")){
						ArrayList<String> item = new ArrayList<String>();
						item.add("fact");
						item.add(getStringFromLine(i));
						items.add(item);
					}
					if(tag.equals("Activity-Link-Name")){
						ArrayList<String> item = new ArrayList<String>();
						item.add("link");
						item.add(getStringFromLine(i));
						item.add(getStringFromLine(i + 1));
						items.add(item);
					}
				}
			}
			json.addActivityInfo(title, startDate, endDate, items);
			index = nextIndex;
		}
	}
	
	//get the value from the tag, finding the first instance
	private static String getStringFromTag(String tag){
		return getStringFromTag(tag, 0);
	}
	
	//get the value from the tag, finding the first instance on or after
	//lineNum
	private static String getStringFromTag(String tag, int lineNum){
		for(int i = lineNum; i < lines.size(); i++){
			String ln = lines.get(i);
			String lnTag = ln.split(":")[0];
			if(lnTag.equals(tag)){
				return ln.replaceFirst(tag + ":", "").trim();
			}
		}
		return "";
	}
	
	//get the tag from the linenumber
	private static String getTagFromLine(int lineNum){
		String ln = lines.get(lineNum);
		return ln.split(":")[0];
	}
	
	//get the value from the linenumber
	private static String getStringFromLine(int lineNum){
		String tag = getTagFromLine(lineNum);
		String ln = lines.get(lineNum);
		return ln.replaceFirst(tag + ":", "").trim();
	}
	
	//get the next instance of tag on or after lineNum
	private static int getTagLocation(String tag, int lineNum){
		for(int i = lineNum; i < lines.size(); i++){
			String ln = lines.get(i);
			String lnTag = ln.split(":")[0];
			if(lnTag.equals(tag))
				return i;
		}
		return -1;
	}
}