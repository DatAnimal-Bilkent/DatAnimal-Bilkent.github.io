import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

public class HelloMysql {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		try
		{
		Connection conn = DriverManager.getConnection("jdbc:mysql://dijkstra.cs.bilkent.edu.tr:3306/mert_duran", "mert.duran", "mkyRf3AL");
		System.out.println("Connected To Database");
		Statement stmt = conn.createStatement();
		stmt.executeUpdate("SET FOREIGN_KEY_CHECKS=0;");
		stmt.executeUpdate("DROP TABLE IF EXISTS Users");
		stmt.executeUpdate("DROP TABLE IF EXISTS Employees");
		stmt.executeUpdate("DROP TABLE IF EXISTS Visitors");
		stmt.executeUpdate("DROP TABLE IF EXISTS Facility_Worker");
		stmt.executeUpdate("DROP TABLE IF EXISTS Keepers");
		stmt.executeUpdate("DROP TABLE IF EXISTS Coordinators");
		stmt.executeUpdate("DROP TABLE IF EXISTS Veterinarians");
		stmt.executeUpdate("DROP TABLE IF EXISTS Animals");
		stmt.executeUpdate("DROP TABLE IF EXISTS Cages");
		stmt.executeUpdate("DROP TABLE IF EXISTS Foods");
		stmt.executeUpdate("DROP TABLE IF EXISTS Stocks");
		stmt.executeUpdate("DROP TABLE IF EXISTS Food_Stocks");
		stmt.executeUpdate("DROP TABLE IF EXISTS Item_Stocks");
		stmt.executeUpdate("DROP TABLE IF EXISTS Facilities");
		stmt.executeUpdate("DROP TABLE IF EXISTS Events");
		stmt.executeUpdate("DROP TABLE IF EXISTS Group_Tours");
		stmt.executeUpdate("DROP TABLE IF EXISTS Educational_Program");
		stmt.executeUpdate("DROP TABLE IF EXISTS Conservation_Organizations");
		stmt.executeUpdate("DROP TABLE IF EXISTS Comments");
		stmt.executeUpdate("DROP TABLE IF EXISTS Complaint_Form");
		stmt.executeUpdate("DROP TABLE IF EXISTS Respond_complaint");
		stmt.executeUpdate("DROP TABLE IF EXISTS Visit");
		stmt.executeUpdate("DROP TABLE IF EXISTS Schedules_Training");
		stmt.executeUpdate("DROP TABLE IF EXISTS Regularizes_Food");
		stmt.executeUpdate("DROP TABLE IF EXISTS Request_Treatment");
		stmt.executeUpdate("DROP TABLE IF EXISTS Writes_Comment");
		stmt.executeUpdate("DROP TABLE IF EXISTS Attends");
		stmt.executeUpdate("DROP TABLE IF EXISTS Assigns_Cage");
		stmt.executeUpdate("DROP TABLE IF EXISTS Make_Donation");
		stmt.executeUpdate("DROP TABLE IF EXISTS Purchase_Stock");
		stmt.executeUpdate("DROP TABLE IF EXISTS Invites_Edu");
		stmt.executeUpdate("DROP TABLE IF EXISTS Has_Stock");
		stmt.executeUpdate("SET FOREIGN_KEY_CHECKS=1;");


		String sql;
		sql = "CREATE TABLE	Users( "
				+ "user_id		int not null,"
				+ "password	varchar(10) not null,"
				+ "email 		varchar(30) not null,"
				+ "phone_no	int not null,"
				+ "birth_year	date not null,"
				+ "name		varchar(15) not null,"
				+ "address		varchar(100) not null,"
				+ "gender		varchar(5) not null,"
				+ "primary key 	(user_id)"
				+ ");"
				+ "";
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE Employees( "
				+ "user_id int not null,"
				+ "position varchar(10) not null,"
				+ "salary_per_hour	int not null,"
				+ "working_hour_per_week	int not null,"
				+ "primary key 		(user_id),"
				+ "foreign key		 (user_id) references Users(user_id)"
				+ ");"
				+ "";
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Visitors( "
				+ "user_id			int not null,"
				+ "occupation		varchar(10) not null,"
				+ "last_visit_date		date,"
				+ "Total_amount_of_money int,"
				+ "primary key 		(user_id),"
				+ "foreign key 		(user_id) references Users(user_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);
		
		sql = "CREATE TABLE 		Facilities ( "
				+ "facility_id		int not null,"
				+ "name			varchar(20) not null,"
				+ "address			varchar(100) not null,"
				+ "collected_money	int not null,"
				+ "primary key 		(facility_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);
		
		sql = "CREATE TABLE 	Facility_Worker ( "
				+ "user_id		int not null,"
				+ "speciality	varchar(10) not null,"
				+ "facility_id	int not null,"
				+ "primary key 	(user_id),"
				+ "foreign key 	(user_id) references Employees(user_id),"
				+ "foreign key 	(facility_id) references Facilities(facility_id)"
				+ ");"
				+ ""; 


		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Keepers( "
				+ "user_id		int not null,"
				+ "speciality	int not null,"
				+ "primary key 	(user_id),"
				+ "foreign key 	(user_id) references Employees(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Coordinators ( "
				+ "user_id		int not null,"
				+ "section		varchar(10) not null,"
				+ "primary key 	(user_id),"
				+ "foreign key 	(user_id) references Employees(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Veterinarians ( "
				+ "user_id		int not null,"
				+ "speciality	varchar(10) not null,"
				+ "primary key 	(user_id),"
				+ "foreign key 	(user_id) references Employees(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);
		
		sql = "CREATE TABLE 	Cages ( "
				+ "cage_id		int not null,"
				+ "location	varchar(100) not null,"
				+ "population	int not null,"
				+ "ecosystem	varchar(20) ,"
				+ "temperature	int,"
				+ "primary key 	(cage_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);
		
		sql = "CREATE TABLE 	Animals( "
				+ "animal_id	int not null,"
				+ "name		varchar(20) not null,"
				+ "birthday	date not null,"
				+ "cage_id		int not null,"
				+ "species		varchar(20),"
				+ "gender		varchar(5),"
				+ "primary key 	(animal_id),"
				+ "foreign key 	(cage_id) references Cages(cage_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Stocks ( "
				+ "stock_id	int not null,"
				+ "unit		varchar(5) not null,"
				+ "last_update	date not null,"
				+ "primary key 	(stock_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE Food_Stocks ( "
				+ "stock_id	int not null,"
				+ "food_type	varchar(10) not null,"
				+ "primary key	 (stock_id),"
				+ "foreign key 	(stock_id) references Stocks(stock_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		
		sql = "CREATE TABLE 		Foods ( "
				+ "food_id			int not null,"
				+ "name			varchar(20) not null,"
				+ "expiration_date	date not null,"
				+ "stock_id		int not null,"
				+ "amount			int not null,"
				+ "primary key 		(food_id),"
				+ "foreign key 		(stock_id) references Food_Stocks(stock_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE	Item_Stocks ( "
				+ "stock_id	int not null,"
				+ "item_type	varchar(10) not null,"
				+ "amount		int not null,"
				+ "primary key 	(stock_id),"
				+ "foreign key	 (stock_id) references Stocks(stock_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);



		sql = "CREATE TABLE 	Events ( "
				+ "event_id	int not null,"
				+ "date		date not null,"
				+ "location	varchar(100) not null,"
				+ "user_id		int not null,"
				+ "name varchar(100) not null,"
				+ "primary key 	(event_id),"
				+ "foreign key 	(user_id) references Coordinators(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Group_Tours ( "
				+ "event_id	int not null,"
				+ "visitor_qouta	int not null,"
				+ "price		int not null,"
				+ "primary key	 (event_id),"
				+ "foreign key	 (event_id) references Events(event_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE	Educational_Program ( "
				+ "event_id	int not null,"
				+ "visitor_qouta	int not null,"
				+ "subject		varchar(20) not null,"
				+ "primary key 	(event_id),"
				+ "foreign key 	(event_id) references Events(event_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Conservation_Organizations ( "
				+ "event_id		int not null,"
				+ "collectedMoney	int not null,"
				+ "primary key 		(event_id),"
				+ "foreign key 		(event_id) references Events(event_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Comments ( "
				+ "comment_id	int not null,"
				+ "topic		varchar(20) not null,"
				+ "text		varchar(200) not null,"
				+ "date		date not null,"
				+ "primary key	(comment_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Complaint_Form ( "
				+ "complaint_id		int not null,"
				+ "topic			varchar(20) not null,"
				+ "text			varchar(200) not null,"
				+ "complaint_date	date not null,"
				+ "user_id			int not null,"
				+ "primary key (complaint_id),"
				+ "foreign key (user_id) references Visitors(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE Respond_complaint  ( "
				+ "complaint_id	int not null,"
				+ "user_id		int not null,"
				+ "respond_note	varchar(200) not null, "
				+ "respond_date	date not null,"
				+ "primary key 	(complaint_id),"
				+ "foreign key 	(complaint_id) references Complaint_Form(complaint_id),"
				+ "foreign key 	(user_id) references Coordinators(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Visit ( "
				+ "visit_id		int not null,"
				+ "date		date not null,"
				+ "entrance_time	time not null, "
				+ "exit_time	time not null,"
				+ "money_spent	int not null,"
				+ "user_id		int not null,"
				+ "primary key 	(visit_id),"
				+ "foreign key 	(user_id) references Visitors(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Schedules_Training  ( "
				+ "animal_id	int not null,"
				+ "user_id		int not null,"
				+ "date_time	datetime not null, "
				+ "type 		varchar(30),"
				+ "primary key 	(animal_id, user_id, date_time),"
				+ "foreign key 	(animal_id) references Animals(animal_id),"
				+ "foreign key (user_id) references Keepers(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Regularizes_Food ( "
				+ "animal_id	int not null,"
				+ "user_id		int not null,"
				+ "cage_id		int not null, "
				+ "food_id		int not null,"
				+ "date_time	datetime not null,"
				+ "primary key 	(food_id, user_id, cage_id, date_time),"
				+ "foreign key 	(food_id) references Foods(food_id),"
				+ "foreign key 	(user_id) references Keepers(user_id),"
				+ "foreign key 	(cage_id) references Cages(cage_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Request_Treatment ( "
				+ "animal_id		int not null,"
				+ "keeper_user_id	int not null,"
				+ "vet_user_id		int not null,"
				+ "date_time		datetime not null,"
				+ "cage_id				int not null,"
				+ "treatment_status 	varchar(30),"
				+ "acc_status 		varchar(30),"
				+ "primary key 		(animal_id, keeper_user_id, vet_user_id, date_time),"
				+ "foreign key 		(keeper_user_id) references Keepers(user_id),"
				+ "foreign key		 (vet_user_id) references Veterinarians(user_id),"
				+ "foreign key 		(cage_id) references Cages(cage_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Writes_Comment ("
				+ "comment_id		int not null,"
				+ "event_id		int not null,"
				+ "user_id			int not null,"
				+ "primary key 		(comment_id),"
				+ "foreign key 		(comment_id) references Comments(comment_id),"
				+ "foreign key 		(event_id) references Group_Tours(event_id),"
				+ "foreign key 		(user_id) references Visitors(user_id)"
				+ ");"
				+ ""; 
		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Attends("
				+ "user_id		int not null,"
				+ "event_id	int not null,"
				+ "payment	float not null,"
				+ "primary key	(user_id, event_id),"
				+ "foreign key 	(event_id) references Group_Tours(event_id),"
				+ "foreign key 	(user_id) references Visitors(user_id)"
				+ ");"
				+ ""; 


		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 			Assigns_Cage("
				+ "coordinator_user_id		int not null,"
				+ "keeper_user_id		int not null,"
				+ "cage_id				int not null,"
				+ "primary key			(coordinator_user_id, keeper_user_id, cage_id),"
				+ "foreign key 			(coordinator_user_id) references Coordinators(user_id),"
				+ "foreign key 			(keeper_user_id) references Keepers(user_id),"
				+ "foreign key 			(cage_id) references Cages(cage_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Make_Donation ("
				+ "event_id 		int not null,"
				+ "user_id			 int not null,"
				+ "donation_amount 	float not null,"
				+ "primary key		(event_id, user_id),"
				+ "foreign key 		(event_id) references Conservation_Organizations(event_id),"
				+ "foreign key 		(user_id) references Visitors(user_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Purchase_Stock ("
				+ "user_id 	int not null,"
				+ "stock_id 	int not null,"
				+ "primary key	(user_id, stock_id), "
				+ "foreign key 	(user_id) references Facility_Worker(user_id),"
				+ "foreign key	(stock_id) references Stocks(stock_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 		Invites_Edu("
				+ "vet_user_id 		int not null,"
				+ "coor_user_id 		int not null,"
				+ "event_id		 int not null,"
				+ "Primary key		(vet_user_id, coor_user_id, event_id),  "
				+ "foreign key 		(coor_user_id) references Coordinators(user_id),"
				+ "foreign key		(vet_user_id) references Veterinarians(user_id),"
				+ "foreign key 		(event_id) references Educational_Program(event_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);

		sql = "CREATE TABLE 	Has_Stock( "
				+ "stock_id	int not null,"
				+ "facility_id	int not null,"
				+ "primary key 	(stock_id, facility_id),"
				+ "foreign key 	(stock_id) references Item_Stocks(stock_id),"
				+ "foreign key	(facility_id) references Facilities(facility_id)"
				+ ");"
				+ ""; 

		stmt.executeUpdate(sql);

	
		//stmt.executeUpdate(sql);

		//stmt.executeUpdate("ALTER TABLE apply ENGINE=InnoDB;");
	
		/*
		stmt.executeUpdate("INSERT INTO student VALUES(21000001, 'John', '1999-05-14', 'Windy', 'Chicago', 'senior', 2.33, 'US');");
		stmt.executeUpdate("INSERT INTO student VALUES(21000002, 'Ali', '2001-09-30', 'Nisantasi', 'Istanbul', 'junior', 3.26, 'TC');");
		stmt.executeUpdate("INSERT INTO student VALUES(21000003, 'Veli', '2003-02-25', 'Nisantasi', 'Istanbul', 'freshman', 2.41, 'TC');");
		stmt.executeUpdate("INSERT INTO student VALUES(21000004, 'Ayse', '2003-01-15', 'Tunali', 'Ankara', 'freshman', 2.55, 'TC');");
		stmt.executeUpdate("INSERT INTO company VALUES('C101', 'microsoft', 2);");
		stmt.executeUpdate("INSERT INTO company VALUES('C102', 'merkez bankasi', 5);");
		stmt.executeUpdate("INSERT INTO company VALUES('C103', 'tai', 3);");
		stmt.executeUpdate("INSERT INTO company VALUES('C104', 'tubitak', 1);");
		stmt.executeUpdate("INSERT INTO company VALUES('C105', 'aselsan', 3);");
		stmt.executeUpdate("INSERT INTO company VALUES('C106', 'havelsan', 4);");
		stmt.executeUpdate("INSERT INTO company VALUES('C107', 'milsoft', 2);");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000001, 'C101');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000001, 'C102');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000001, 'C103');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000002, 'C101');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000002, 'C105');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000003, 'C104');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000003, 'C105');");
		stmt.executeUpdate("INSERT INTO apply VALUES(21000004, 'C107');");
		
        ResultSet rS = stmt.executeQuery("SELECT * FROM student");
        while (rS.next()) {

            System.out.println(rS.getString("sid") +" "+ rS.getString("sname") +" "+ rS.getString("bdate") +" "+ 
            rS.getString("address") +" "+ rS.getString("scity") +" "+ rS.getString("year")+" "+
            		rS.getString("gpa") +" " + rS.getString("nationality"));
        }
		 */
		System.out.println("Finished Implementing.");

		}catch(Exception e)
		{
		System.err.println(e);
		System.out.println("Could not connected.");
		}

	}

}
