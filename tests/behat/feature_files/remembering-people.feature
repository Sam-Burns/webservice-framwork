Feature: Remembering people

    As an HR director
    In order to remember who is in Compliance
    I want to remember all their names

    Background:
        Given 'Jeremy' is a 'Scrum-Master'
        And 'Deepa' is a 'Project Manager'
        And 'Abi' is a 'QA'
        And 'Hash' is a 'Dev'
        And 'Sam' is a 'Dev'
        And 'Tahir' is a 'Dev'
        And 'Ziad' is a 'Dev'

    @servicelevel @applicationlevel @httplevel
    Scenario: Getting everyone from the DB
        When I look up all the people in the team
        Then I should get 7 people
        And one of them should be called 'Tahir'

    @servicelevel
    Scenario: Finding out someone's job
        When I look up what Hash's job is
        Then I should see he is a 'Dev'

    @servicelevel
    Scenario: Finding the number of team members with a prime number of vowels in their name
        When I look up the number of team members with a prime number of vowels in their name
        Then I should find that there are 5
