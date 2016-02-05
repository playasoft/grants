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
 - [x] Type (Input, Text, Dropdown, Boolean)
 - [x] Options (JSON, Optional, used for dropdowns, and for weighted booleans)
 - [x] Status (This question will only appear when an application is within a specific status)
 - [x] Role (User role this question should be shown to: Applicant or Judge)
 - [x] Required
 - [x] Parent
 - [x] Order

- Applications
 - [x] Name
 - [x] Description
 - [x] Status (New, Submitted, Review, Follow Up, Accepted, Rejected)
 - [x] Applicant Score
 - [x] Judge Score
 - [x] User ID

- Answers
 - [x] Application ID
 - [x] Question ID
 - [x] Answer

- Documents
 - [ ] Name
 - [ ] Description
 - [ ] File
 - [ ] Application ID
 - [ ] Admin ID (Useful for tracking if admins have attached a file to an application)

- Feedback
 - [ ] Feedback (So judges can ask questions or give criticism)
 - [ ] Type (Input, Text, Dropdown, Boolean)
 - [ ] Options (JSON, Optional, only for dropdowns at the moment)
 - [ ] Response (Response from the user)
 - [ ] Application ID
 - [ ] Admin ID (Which admin sent the feedback)
 - [ ] Regarding ID (The ID of the data this feedback is related to, if any)
 - [ ] Regarding Type (Can be a question or a document)

- Scores
 - [ ] Score
 - [ ] Application ID
 - [ ] Admin ID
 - [ ] Question ID


## Pages
- [x] Home page
- [ ] User dashboard
- [ ] Admin dashboard
- [ ] Judge dashboard
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
- [ ] One to many + One to one between applications <-> documents
- [ ] One to one between documents -> admins (users) 
- [ ] One to one + One to many between feedback <-> applications
- [ ] One to one between feedback -> admins (users)
- [ ] One to one polymorphic between feedback -> answers and documents
- [ ] One to one + One to many between scores <-> applications
- [ ] One to one between scores -> admins (users)
- [ ] One to one btween scores -> questions


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
- [ ] Uploading files
- [ ] Submitting applications
- [ ] Server-side checking for required answers
- [ ] Client-side checking for required answers
- [ ] AJAX autosave for answers
- [ ] Pop-up notification warning user when submitting application


## Judge Workflow
- [ ] View submitted applications
- [ ] Rate user answers
- [ ] Rate judge questions
- [ ] Provide feedback
- [ ] Approve / deny applications
