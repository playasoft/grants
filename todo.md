# Basic project setup

## Auth
- [ ] Create user controller
- [ ] Set up auth provider
- [ ] Registration
- [ ] Login
- [ ] Permissions per page


## Models
- Users
 - [ ] Name
 - [ ] Email
 - [ ] Password
 - [ ] Role (Admin, Applicant, Judge, Observer)

- Questions
 - [ ] Question
 - [ ] Type (Input, Text, Dropdown, Boolean)
 - [ ] Options (JSON, Optional, used for dropdowns, and for weighted booleans)
 - [ ] Status (This question will only appear when an application is within a specific status)
 - [ ] Required
 - [ ] Parent
 - [ ] Order

- Criteria
 - [ ] Criteria
 - [ ] Type (Dropdown, Boolean)
 - [ ] Options (JSON, Optional, used for dropdowns, and for weighted booleans)

- Applications
 - [ ] Name
 - [ ] Description
 - [ ] Status (New, Submitted, Review, Follow Up, Accepted, Rejected)
 - [ ] Objective Score
 - [ ] Subjective Score
 - [ ] User ID

- Documents
 - [ ] Name
 - [ ] Description
 - [ ] File
 - [ ] Application ID
 - [ ] Admin ID (Useful for tracking if admins have attached a file to an application)

- Answers
 - [ ] Application ID
 - [ ] Question ID
 - [ ] Answer

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
 - [ ] Source ID
 - [ ] Source Type


## Pages
- [ ] Home page
- [ ] User dashboard
- [ ] Admin dashboard
- [ ] Judge dashboard
- [ ] Create question
- [ ] Create criteria
- [ ] Create application
- [ ] Answering questions
- [ ] Judging applications
- [ ] Follow up questions


## Relationships
- [ ] Relationship between users and applications
- [ ] Relationship between applications and questions ???
- [ ] Relationship between applications and criteria ???


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
