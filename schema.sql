-- Enums
CREATE TYPE access_level AS ENUM ('Admin', 'Officer', 'Committee', 'Viewer');
CREATE TYPE committee_type AS ENUM ('Secretariat', 'Logistics', 'Finance', 'Creatives', 'Chief of Staff', 'UNDEFINED');
CREATE TYPE approval_status AS ENUM ('Pending', 'Accepted', 'Rejected');
CREATE TYPE category_enum AS ENUM ('Internal', 'External', 'Confidential');

-- Officers Table
CREATE TABLE Officers (
    OfficerID SERIAL PRIMARY KEY,
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    Age INT,
    ContactNumber VARCHAR(15),
    Course VARCHAR(50),
    YearLevel INT,
    Position VARCHAR(50),
    DateAssumed DATE,
    DateEnded DATE,
    TermYear VARCHAR(15),
    AccessLevel access_level DEFAULT 'Viewer'
);

-- Committees Table
CREATE TABLE Committees (
    CommitteeID SERIAL PRIMARY KEY,
    OfficerID INT REFERENCES Officers(OfficerID) ON DELETE SET NULL,
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    Age INT,
    Course VARCHAR(50),
    YearLevel INT,
    ContactNumber VARCHAR(15),
    SchoolEmail VARCHAR(255),
    CommitteeType committee_type DEFAULT 'UNDEFINED',
    TermYear VARCHAR(15)
);

-- Email Table
CREATE TABLE Email (
    EmailID SERIAL PRIMARY KEY,
    OfficerID INT REFERENCES Officers(OfficerID) ON DELETE CASCADE,
    Email VARCHAR(255) NOT NULL
);

-- Account Table
CREATE TABLE Account (
    AccountID SERIAL PRIMARY KEY,
    OfficerID INT REFERENCES Officers(OfficerID) ON DELETE CASCADE,
    Password VARCHAR(255) NOT NULL
);

-- AuditLog Table
CREATE TABLE AuditLog (
    ActivityID SERIAL PRIMARY KEY,
    OfficerID INT REFERENCES Officers(OfficerID) ON DELETE SET NULL,
    Activity VARCHAR(255) NOT NULL,
    ActivityDate DATE DEFAULT CURRENT_DATE,
    ActivityTime TIME DEFAULT CURRENT_TIME
);

-- ApproveLog Table
CREATE TABLE ApproveLog (
    ApprovalID SERIAL PRIMARY KEY,
    OfficerID INT REFERENCES Officers(OfficerID) ON DELETE SET NULL,
    Notes TEXT,
    ApprovalDate DATE DEFAULT CURRENT_DATE,
    ApprovalTime TIME DEFAULT CURRENT_TIME,
    ApprovalStatus approval_status DEFAULT 'Pending'
);

-- DocumentArchive Table
CREATE TABLE DocumentArchive (
    DocumentID SERIAL PRIMARY KEY,
    ApprovalID INT REFERENCES ApproveLog(ApprovalID) ON DELETE SET NULL,
    DocumentName VARCHAR(255) NOT NULL,
    DocumentDescription VARCHAR(255),
    VersionNumber VARCHAR(5),
    DocumentFilePath VARCHAR(255),
    DocumentType VARCHAR(50),
    Category category_enum DEFAULT 'Internal',
    OfficerInCharge VARCHAR(100),
    CreationDate DATE DEFAULT CURRENT_DATE,
    CreationTime TIME DEFAULT CURRENT_TIME,
    AssociatedEvent VARCHAR(255),
    TermYear VARCHAR(15)
);
