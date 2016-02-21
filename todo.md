# Basic project setup

## Auth
- [x] Create user controller
- [x] Set up auth provider
- [x] Registration
- [x] Login
- [x] Permissions per page


## Models
- Users
 - [x] Name
 - [x] Email
 - [x] Password
 - [x] Role (Admin, Applicant, Judge, Observer)

- Questions
 - [x] Question
 - [x] Type (Input, Text, Dropdown, Boolean, File)
 - [x] Options (Text, only used for dropdowns for now)
 - [x] Required
 - [x] Parent
 - [x] Order

- Applications
 - [x] Name
 - [x] Description
 - [x] Status (New, Submitted, Review, Follow Up, Accepted, Rejected)
 - [-] Objective Score
 - [-] Subjective Score
 - [ ] Total Score
 - [ ] Scored (Boolean)
 - [x] User ID

- Answers
 - [x] Application ID
 - [x] Question ID
 - [x] Answer

- Documents
 - [x] Name
 - [x] Description
 - [x] File
 - [x] Application ID
 - [x] Answer ID (Nullable, cascade on delete set null)
 - [x] User ID (Useful for tracking if admins have attached a file to an application)

- Criteria
 - [ ] Question
 - [ ] Type (Objective, Subjective)
 - [ ] Required
 - [ ] Parent
 - [ ] Order

- Scores
 - [ ] Application ID
 - [ ] Criteria ID
 - [ ] Admin ID
 - [ ] Answer
 - [ ] Score

- Feedback
 - [ ] Feedback (So judges can ask questions or give criticism)
 - [ ] Type (Input, Text, Dropdown, Boolean, File)
 - [ ] Options (Text, only used for dropdowns now)
 - [ ] Response (Response from the user)
 - [ ] Application ID
 - [ ] User ID (Which admin sent the feedback)
 - [ ] Regarding ID (The ID of the data this feedback is related to, if any)
 - [ ] Regarding Type (Can be a question or a document)


## Pages
- [x] Home page
- [x] User dashboard
- [ ] Admin dashboard
- [x] Judge dashboard
- [x] Create question
- [x] Create application
- [x] Answering questions
- [ ] Judging applications
- [ ] Follow up questions


## Relationships
- [x] One to many + One to one between users <-> applications
- [x] One to one + One to many between answers <-> applications
- [x] One to one between answers -> questions
- [ ] One to many + One to one between questions <-> question children
- [x] One to many + One to one between applications <-> documents
- [x] One to many + One to one between questions <-> documents
- [x] One to one between documents -> admins (users) 
- [ ] One to one + One to many between feedback <-> applications
- [ ] One to one between feedback -> admins (users)
- [ ] One to one polymorphic between feedback -> answers and documents
- [ ] One to one + One to many between scores <-> applications
- [ ] One to one between scores -> admins (users)
- [ ] One to one btween scores -> critera


## Defined Events
- [ ] User Registered
- [ ] Application Submitted
- [ ] Application Needs Review
- [ ] Application Accepted
- [ ] Application Rejected


## Event Handlers
- [ ] Send user email when user is registered
- [ ] Send judges email when application is submitted
- [ ] Send user email when application needs review
- [ ] Send user email when application is accepted
- [ ] Send user email when application is rejected


## User Workflow
- [x] Create application
- [x] Update application
- [x] Answer questions
- [x] Uploading files
- [x] Review page
- [x] Submitting applications
- [x] Server-side checking for required answers
- [x] AJAX autosave for answers


## Judge Workflow
- [x] View submitted applications
- [x] Remove per-question rating options
- [ ] Display judge criteria on review page
- [ ] AJAX autosave for judge answers / ratings
- [ ] Automated score aggregation on a cron
- [ ] Provide feedback
- [ ] Approve / deny applications
