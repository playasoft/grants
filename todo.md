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
 - [x] Objective Score
 - [x] Subjective Score
 - [x] Total Score
 - [x] Scored (Boolean)
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
 - [x] Question
 - [x] Type (Objective, Subjective)
 - [x] Required
 - [x] Parent
 - [x] Order

- Scores
 - [x] Score
 - [x] Answer
 - [x] Application ID
 - [x] Criteria ID
 - [x] User ID (Judge)

- Judged
 - [x] Application ID
 - [x] User ID (Judge)

- Feedback
 - [x] Message (So judges can ask questions or give criticism)
 - [x] Type (Input, Text, Dropdown, Boolean, File)
 - [x] Options (Text, only used for dropdowns now)
 - [x] Response (Response from the user)
 - [x] Application ID
 - [x] User ID (Which judge requested the feedback)
 - [x] Regarding ID (The ID of the data this feedback is related to, if any)
 - [x] Regarding Type (Can be a question or a document)


## Pages
- [x] Home page
- [x] User dashboard
- [ ] Admin dashboard
- [x] Judge dashboard
- [x] Create question
- [x] Create application
- [x] Answering questions
- [x] Judging applications
- [x] Follow up questions


## Relationships
- [x] One to many + One to one between users <-> applications
- [x] One to one + One to many between answers <-> applications
- [x] One to one between answers -> questions
- [ ] One to many + One to one between questions <-> question children
- [x] One to many + One to one between applications <-> documents
- [x] One to many + One to one between questions <-> documents
- [x] One to one between documents -> judges (users) 
- [x] One to one + One to many between feedback <-> applications
- [x] One to one between feedback -> judges (users)
- [x] One to one polymorphic between feedback -> answers and documents
- [x] One to one + One to many between scores <-> applications
- [x] One to one between scores -> critera
- [x] One to one between scores -> judges (users)


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
- [x] Display judge criteria on review page
- [x] AJAX autosave for judge answers / ratings
- [x] Judge submitting final answers / ratings
- [x] Server-side checking for required answers
- [x] Score aggregation when ratings are submitted
- [x] Provide feedback
- [x] Approve / deny applications
