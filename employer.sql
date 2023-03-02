/*
Comandos para a recriar o banco de dados no PostgresQL, para o funcionamento do site.
*/

CREATE TABLE EMPLOYEE
( Fname           VARCHAR(15)      NOT NULL,
  Minit           CHAR,
  Lname           VARCHAR(20)      NOT NULL,
  cpf		      CHAR(11)         NOT NULL,
  Bdate           DATE,
  Address         VARCHAR(30),
  Sex             CHAR(1),
  Salary          DECIMAL(5),
  cnh             CHAR(1),
  Super_cpf       CHAR(11),
  Dno             INT               NOT NULL,
PRIMARY KEY   (cpf));

CREATE TABLE DEPARTMENT
( Dname           VARCHAR(15)       NOT NULL,
  Dnumber         SERIAL            NOT NULL,
  Mgr_cpf         CHAR(11)           NOT NULL,
  Mgr_start_date  DATE,
PRIMARY KEY (Dnumber),
UNIQUE      (Dname),
FOREIGN KEY (Mgr_cpf) REFERENCES EMPLOYEE(cpf) );

CREATE TABLE DEPT_LOCATIONS
( Dnumber         INT               NOT NULL,
  Dlocation       VARCHAR(15)       NOT NULL,
PRIMARY KEY (Dnumber, Dlocation),
FOREIGN KEY (Dnumber) REFERENCES DEPARTMENT(Dnumber) );

CREATE TABLE PROJECT
( Pname           VARCHAR(15)       NOT NULL,
  Pnumber         SERIAL            NOT NULL,
  Plocation       VARCHAR(15),
  Dnum            INT               NOT NULL,
PRIMARY KEY (Pnumber),
UNIQUE      (Pname),
FOREIGN KEY (Dnum) REFERENCES DEPARTMENT(Dnumber) );

CREATE TABLE WORKS_ON
( Ecpf            CHAR(11)          NOT NULL,
  Pno             INT               NOT NULL,
  Hours           DECIMAL(3,1)      NOT NULL,
PRIMARY KEY (Ecpf, Pno),
FOREIGN KEY (Ecpf) REFERENCES EMPLOYEE(cpf),
FOREIGN KEY (Pno) REFERENCES PROJECT(Pnumber) );

CREATE TABLE DEPENDENT
( Ecpf            CHAR(11)          NOT NULL,
  Dependent_name  VARCHAR(15)       NOT NULL,
  Sex             CHAR,
  Bdate           DATE,
  Relationship    VARCHAR(8),
PRIMARY KEY (Ecpf, Dependent_name),
FOREIGN KEY (Ecpf) REFERENCES EMPLOYEE(cpf) );

INSERT INTO EMPLOYEE
VALUES      ('John','Smith',11123456789,'1965-01-09','Fondren, Houston TX','M',30000,'S',11333445555,3),
            ('Franklin','Wong',11333445555,'1965-12-08','Voss, Houston TX','M',40000,'N',11888665555,3),
            ('Alicia','Zelaya',11999887777,'1968-01-19','Castle, Spring TX','F',25000,'N',11987654321,2),
            ('Jennifer','Wallace',11987654321,'1941-06-20','Berry, Bellaire TX','F',43000,'S',11888665555,2),
            ('Fabio','Troncao',11666884444,'1989-03-03','Fire Oak, Humble TX','M',88000,'S',11333445555,3),
            ('Joyce','English',11453453453,'1972-07-31','Rice, Houston TX','F',25000,'N',11333445555,3),
            ('Ahmad','Jabbar',11987987987,'1969-03-29','Dallas, Houston TX','M',25000,'S',11987654321,2),
            ('James','Borg',11888665555,'1937-11-10','Stone, Houston TX','M',55000,'N',null,1);

INSERT INTO DEPARTMENT
VALUES      ('T. Agua',5,11666884444,'1981-02-11'),
	        ('Stock',4,11987654321,'1981-06-19'),
	        ('Maquinas',3,11333445555,'1988-05-22'),
            ('Administrativo',2,11987654321,'1995-01-01'),
            ('Qualidade',1,11888665555,'1981-06-19');
	    
INSERT INTO PROJECT
VALUES      ('Tratar agua',1,'Exterior',5),
            ('Criar papel',2,'Sector1',3),
            ('controle de stock',3,'Armazem',4),
            ('Financeiro',10,'setorADM',2),
            ('teste qualidade',20,'Laboratorio',1),
            ('stock interno',30,'almoxarifado',4);

INSERT INTO WORKS_ON
VALUES     (11123456789,1,32.5),
           (11123456789,2,7.5),
           (11666884444,3,40.0),
           (11453453453,1,20.0),
           (11453453453,2,20.0),
           (11333445555,2,10.0),
           (11333445555,3,10.0),
           (11333445555,10,10.0),
           (11333445555,20,10.0),
           (11999887777,30,30.0),
           (11999887777,10,10.0),
           (11987987987,10,35.0),
           (11987987987,30,5.0),
           (11987654321,30,20.0),
           (11987654321,20,15.0),
           (11888665555,20,16.0);

INSERT INTO DEPENDENT
VALUES      (11333445555,'Alice','F','1986-04-04','filha'),
            (11333445555,'Theodore','M','1983-10-25','filho'),
            (11333445555,'Joy','F','1958-05-03','esposa'),
            (11987654321,'Abner','M','1942-02-28','esposa'),
            (11123456789,'Michael','M','1988-01-04','Son'),
            (11123456789,'Alice','F','1988-12-30','filha'),
            (11123456789,'Elizabeth','F','1967-05-05','esposo');

INSERT INTO DEPT_LOCATIONS
VALUES      (1,'Laboratorio'),
            (2,'setorADM'),
            (3,'Exterior'),
            (3,'Sector1'),
            (3,'Laboratorio');

ALTER TABLE DEPARTMENT
 ADD CONSTRAINT Dep_emp FOREIGN KEY (Mgr_cpf) REFERENCES EMPLOYEE(cpf);

ALTER TABLE EMPLOYEE
 ADD CONSTRAINT Emp_emp FOREIGN KEY (Super_cpf) REFERENCES EMPLOYEE(cpf);

ALTER TABLE EMPLOYEE
 ADD CONSTRAINT Emp_dno FOREIGN KEY  (Dno) REFERENCES DEPARTMENT(Dnumber);

ALTER TABLE EMPLOYEE
 ADD CONSTRAINT Emp_super FOREIGN KEY  (Super_cpf) REFERENCES EMPLOYEE(cpf);