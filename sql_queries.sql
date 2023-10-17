use Sportspark;

/*shows user ID, full name, and email address of all members, ordered by user id*/
select User_ID, concat(First_Name, ' ', Last_Name) as "Full name", Email_Address from user where UserType = 'MEM' order by user_ID asc;

/*count number of each membership level*/
select membership_level, count(user_id) as 'number of members' from member group by membership_level;

/*shows full name and email of members with no membership level set*/
select member.user_id, concat(user.first_name, ' ', user.last_name) as 'full name', user.email_address from member inner join user on member.user_id = user.user_id where member.membership_level is null;

/*employee, their managers's full name, and manager's email address*/
select concat(e.first_name, ' ', e.last_name) as 'employee name', concat(m.first_name, ' ', m.last_name) as 'manager name', m.email_address as "manager's email address" 
from managers inner join user m inner join user e 
where m.user_id = managers.manager_id and e.user_id = managers.employee_id;

/*full name of employees that can instruct football*/
select concat(first_name, ' ', last_name) as 'full name' from user where user_id = any (select user_id from employeesports where sport = 'football');
