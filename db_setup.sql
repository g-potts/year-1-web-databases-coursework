drop database if exists Sportspark;

create database Sportspark;
use Sportspark;

/*user*/
drop table if exists User;
create table User(
    User_ID int unique not null,
    First_Name varchar(255) not null,
    Last_Name varchar(255) not null,
    DOB date,
    Email_Address varchar(255) unique not null,
    _Password varchar(255) not null,
    UserType enum('EMP', 'MEM'),

    primary key (User_ID)
);
insert into User values
(1111, 'John', 'Smith', '2000-01-01', 'johnsmith@gmail,com', 'Password123', 'MEM'),
(1234, 'Alison', 'Crane', '2002-11-29', 'papercrane@yahoo.co.uk', 'pineapple30', 'MEM'),
(1259, 'Caine', 'Eury', '1990-04-17', 'eurycaine@gmail.com', 'adomit97', 'MEM'),
(1376, 'Jodie', 'Wood', '1997-04-19', 'jw67345@surrey.ac.uk', 'abde987', 'MEM'),
(1956, 'Cameron', 'Cross', '2004-02-22', 'cc00894@surrey.ac.uk', 'thq?!57*xzy', 'MEM'),
(1953, 'David', 'Keller', '1977-08-31', 'DavidMKeller@yahoo.co.uk', 'Eengee4voo', 'MEM'),
(1806, 'Sam', 'Warner', '1976-12-18', 'Warner22@gmail.com', 'passwordpassword', 'MEM'),
(1477, 'Maisie', 'Barton', '1990-02-18', 'mbarton@gmail.com', '45mango', 'MEM'),
(1852, 'Natasha', 'Waters', '2000-07-10', 'nw614687@surrey.ac.uk', 'rose3J', 'MEM'),
(1985, 'Bailey', 'Barlow', '2002-04-11', 'bb543384@surrey.ac.uk', '33bb11', 'MEM'),

(2345, 'David', 'Niel', '1980-07-16', 'davidoneil@surreysportspark.co.uk', 'passwordpassword', 'EMP'),
(2779, 'Lucy', 'Black', '1995-06-12', 'lucyblack@surreysportspark.co.uk', 'bhiwuj47898t', 'EMP'),
(2865, 'Tanya', 'Mikniel', '1965-10-31', 'tanyamikniel@surreysportspark.co.uk', 'gjb3487', 'EMP'),
(2956, 'Mike', 'Ross', '1982-05-05', 'mikeross@surreysportspark.co.uk', '67gfh', 'EMP'),
(2164, 'Harvey', 'Specter', '1988-12-21', 'harveyspecter@surreysportspark.co.uk', 'Password321', 'EMP'),
(2065, 'Laura', 'Hill', '1989-03-05', 'laurahill@surreysportspark.co.uk', 'ooPah8Aem', 'EMP'),
(2004, 'Johnny', 'Quinto', '1990-10-28', 'johnnyquinto@surreysportspark.co.uk', 'MgeTr45?', 'EMP'),
(2747, 'Sarah', 'Danger', '1992-02-04', 'sarahdanger@surreysportspark.co.uk', '836hgjWR', 'EMP'),
(2368, 'Fred', 'Smith', '2000-03-01', 'fredsmith@surreysportspark.co.uk', '123454321a', 'EMP'), 
(2858, 'Gerald', 'Jones', '2005-09-07', 'geraldjones@surreysportspark.co.uk', 'nhrMH67', 'EMP');


/*employee*/
drop table if exists Employee;
create table Employee(
    User_ID int unique not null,
    Department varchar(255),

    primary key (User_ID),
    foreign key (User_ID) references User(User_ID)
);
insert into Employee values 
(2345, 'Gym'),
(2779, 'Receptionist'),
(2865, 'Receptionist'),
(2956, 'Personal Trainer'),
(2164, 'Manager'),
(2065, 'Instructor'),
(2004, 'Instructor'),
(2747, 'Manager'),
(2368, 'Instructor'),
(2858, 'Receptionist');



/*employee manages employee - unary relation*/
drop table if exists Managers;
create table Managers(
    Manager_ID int not null,
    Employee_ID int not null,

    primary key (Manager_ID, Employee_ID),
    foreign key (Manager_ID) references Employee(User_ID),
    foreign key (Employee_ID) references Employee(User_ID)
);
insert into Managers values
(2345, 2779),
(2345, 2956),
(2779, 2865),
(2956, 2164),
(2345, 2747),
(2747, 2065),
(2747, 2004),
(2747, 2368),
(2747, 2858);



/*member*/
drop table if exists Member;
create table Member(
    User_ID int unique not null,
    Membership_Level enum('Gold', 'Silver', 'Standard'),

    primary key (User_ID),
    foreign key (User_ID) references User(User_ID)
);
insert into Member values
(1111, 'Gold'),
(1234, 'Silver'),
(1259, 'Standard'),
(1376, 'Silver'),
(1956, null),
(1953, 'Gold'),
(1806, 'Silver'),
(1477, 'Gold'),
(1852, 'Standard'),
(1985, null);



/*location*/
drop table if exists Locations;
create table Locations(
    Location_Type enum('Indoor Court', 'Tennis Court', 'Football Pitch', 'Rugby Pitch', 'Gym', 'Pool') unique not null,
    Location_Amount int not null,
    Capacity int not null,

    primary key (Location_Type)
);

insert into Locations values
('Indoor Court', 3, 30),
('Tennis Court', 5, 4),
('Football Pitch', 3, 22), 
('Rugby Pitch', 2, 35),
('Gym', 1, 50),
('Pool', 1, 20);



/*sport*/
drop table if exists Sports;
create table Sports(
    Sport_Name varchar(255) unique not null,
    Location_Type_Required enum('Indoor Court', 'Tennis Court', 'Football Pitch', 'Rugby Pitch', 'Gym', 'Pool') not null,

    primary key (Sport_Name),
    foreign key (Location_Type_Required) references Locations(Location_Type)
);

insert into Sports values
('Football', 'Football Pitch'),
('Volleyball', 'Indoor Court'),
('Basketball', 'Indoor Court'),
('Rugby', 'Rugby Pitch'),
('Water Polo', 'Pool'),
('Gym Session', 'Gym'),
('Tennis', 'Tennis Court');



/*class*/
drop table if exists Classes;
create table Classes(
    Class_ID varchar(255) unique not null,
    _DateTime datetime not null,
    Sport_Name varchar(255) not null,
    Location_ID enum('Indoor Court', 'Tennis Court', 'Football Pitch', 'Rugby Pitch', 'Gym', 'Pool') not null,
    Instructor_ID int not null,
    Spaces_Booked int not null,
    Price int,

    primary key (Class_ID),
    foreign key (Sport_Name) references Sports(Sport_Name),
    foreign key (Location_ID) references Locations(Location_Type),
    foreign key (Instructor_ID) references Employee(User_ID)
);
insert into Classes values /*mon 2 - sun 8 jan 2023*/
('TEN020123', '2023-01-02 10:00:00', 'Tennis', 'Tennis Court', 2779, 0, 10), /*[TEN080123] mon 2 10am, tennis, tennis court, inst 2779, 0, 10*/
('POL030123', '2023-01-03 12:00:00', 'Water Polo', 'Pool', 2164, 0, 12), /*[POL090123] tues 3 12pm, water polo, pool, 2164, 0, 12*/
('FBL040123', '2023-01-04 14:00:00', 'Football', 'Football Pitch', 2345, 0, 5), /*[FBL100123] wed 4 2pm, football, football pitch, 2345, 0, 5*/
('RUG040123', '2023-01-04 15:00:00', 'Rugby', 'Rugby Pitch', 2865, 0, 3), /*[RUG040123] wed 4 3pm, rugby, rugby pitch, 2865, 0, 3*/
('BAS050123', '2023-01-05 17:00:00', 'Basketball', 'Indoor Court', 2956, 0, 5), /*[BAS050123]thurs 5 5pm, basketball, indoor court, 2956, 0, 5*/
('FBL060123', '2023-01-06 18:00:00', 'Football', 'Football Pitch', 2865, 0, 5), /*[FBL060123]fri 6 6pm, football, football pitch, 2865, 0, 5*/
('VOL080123', '2023-01-08 17:30:00', 'Volleyball', 'Indoor Court', 2779, 0, 3); /*[VOL080123]sun 8 5:30pm volleyball, indoor court, 2779, 0, 3*/



/*booking*/
drop table if exists Booking;
create table Booking(
    Booking_ID int unique not null,
    User_ID int not null,
    Class_ID varchar(255) not null,
    Paid_Status boolean not null,

    primary key (Booking_ID),
    foreign key (User_ID) references Member(User_ID),
    foreign key (Class_ID) references Classes(Class_ID)
);

insert into Booking values
(100, 1111, 'TEN020123', 1),
(101, 1234, 'POL030123', 1),
(102, 1259, 'FBL040123', 1),
(103, 1376, 'RUG040123', 1),
(104, 1956, 'BAS050123', 1),
(105, 1953, 'FBL060123', 1),
(106, 1806, 'VOL080123', 1),
(107, 1477, 'VOL080123', 1),
(108, 1852, 'FBL060123', 1),
(109, 1985, 'VOL080123', 1);


/*employee sports multivalued attribute*/
drop table if exists EmployeeSports;
create table EmployeeSports(
    User_ID int not null,
    Sport varchar(255) not null,

    primary key (User_ID, Sport),
    foreign key (User_ID) references User(User_ID),
    foreign key (Sport) references Sports(Sport_Name)

);

insert into EmployeeSports values
(2345, 'Football'),
(2779, 'Volleyball'),
(2779, 'Tennis'),
(2865, 'Football'),
(2865, 'Rugby'),
(2956, 'Basketball'),
(2164, 'Water Polo');