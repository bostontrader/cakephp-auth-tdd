<h1>Introduction</h1>
The purpose of this repository is to assemble some useful
techniques into a starter installation of CakePHP.  Said techniques
include:

<ul>
<li>The implementation of the blog tutorial from the CakePHP Cookbook.</li>

<li>Implementation of authentication and authorization using the Auth
component.</li>

<li>Development of this via a step-by-step test-driven development (TDD) process,
using the available CakePHP testing tools.</li>
</ul>

All of these elements can be easily found on the Internet, individually, and I've even seen a few combos of
any two of them.  But I've never encountered a careful example that uses all three
of them.  In this repository, I hope to remedy that situation.

I have particularly found that testing, authentication, and authorization are difficult to put to
actual use.  Although easy enough to get random fragments of this puzzle working via various tutorials
and self-study, these three amigos conspire to create a bottomless pit of complexity to deal with.
What can we do to limit this complexity and find a practical approach to getting started with these subjects?
That's what I try to explain in this repository.

<h2>How to Use This Repository</h2>

Starting with commit e50756 this repository supplies a beginning CakePHP 2.6 installation.
Thereafter, I have an essay, or perhaps merely a terse description, describing each subsequent baby-step
taken in pursuit of the Goal.  In each of these steps, I'll go through the TDD dance.  That is,
make a test, watch it fail, implement whatever is needed to make the test past.  Along the way,
I'll explain whatever needs explaining.

Given the magic of git, it's easy to back and forth to whatever version you want.  You can start at the beginning, 
the end, or anywhere, and work your way through whatever parts of this baffle you. 

<h2>Acknowledgements</h2>
I'd like to thank the following for their contributions of code samples, advice, or inspiration:
<ul>
<li>http://zenofcoding.com/2012/05/09/user-auth-with-cakephp-2-1-part-1/</li>
<li>http://zenofcoding.com/2012/07/04/building-the-blog-tutorial-the-tdd-way-part-1-model-testing/</li>
<li>http://mark-story.com/posts/view/testing-cakephp-controllers-the-hard-way</li>
<li>http://stackoverflow.com/questions/18225327/unit-testing-the-auth-component</li>
<li>http://stackoverflow.com/questions/16448178/cakephp-controller-testing-mocking-the-auth-component</li>
<li>http://stackoverflow.com/questions/15750135/cakephp-2-3-unit-testing-user-login</li>
<li>http://stackoverflow.com/questions/8216434/write-unit-test-for-a-controller-that-uses-authcomponent-in-cakephp-2</li>
<li>http://stackoverflow.com/questions/10578598/why-isauthorized-is-never-called-when-running-controller-tests</li>
<li>The giants upon whose shoulders I generally am privileged to stand upon.</li>
</ul>

<h2>Getting Started</h2>

<ol>
<li>Clone this repository somewhere convenient for your development tools.</li>
<li>Switch to whichever commit you want to use.  Recall that commit e50756 is the starting
point.</li>
<li>Configure a web-server to serve this code.</li>
<li>Be sure to configure your web-server to support relevant tools of debuggery such as xdebug.</li>
<li>Configure your database to work with this code.</li>
<li>Configure your IDE to work with this source code and debug tools.</li>
<li>Learn how to execute your tests.  Either from the web browser or command-line.
An example for running the tests from the web browser might be...<b>http://localhost/cakephp-auth-tdd/test.php</b></li>
</ol>

These steps are outside the scope of this document and there are simply way too many
variations and nuances for me to deal with here.  Your hello-world goal at this step is to see the
CakePHP welcome screen running from this code.

<h2>Here we go!</h2>

<h3>1. Ignore the PagesController</h3>

The PagesController comes with CakePHP and has presumably already been tested.  So let's not
waste our effort testing that.

<h3>2. The User model</h3>

It's not hard to guess that we're going to need a table to store the user information.  So let's
start testing in that direction.  Note: I'm going to go through this step in tedious detail
to illustrate some issues.  I will pick up the pace in subsequent steps.

<b>commit-e8eac7.</b>  If we run Model/UserTest at this time, we'll get an error: No tests found in class "UserTest".  Well duh!  The beginning test doesn't contain any tests.  Let's fix that by adding a simple test that does nothing.  Although the test does nothing, it
looks like a test and thus makes the class a valid CakeTestCase.

<b>commit- a49e85.</b>  If we run the test now, it's all green.  Great! Onward through the fog.

Now we want to make a test that will do something with the model.  Again we guess that
we'll likely want some means of getting all the User records.  So let's create a test to invoke a method getAllUsers on the User model.  We haven't yet created a users table in the db, a Users model in Cake, nor a method getAllUsers.  So we guess this test will probably fail now.

<b>commit- f2cfb3.</b>  When we run the test now, it fails because "Table users for model User was not found in datasource test".

The immediate cause of this is that we have no users table in the "test" db. Recall that Config/database.php
has various datasources configured in it.  The most common configuration is named "default" and is what Cake uses by default.  The next configuration is named "test".

We now want to create the simplest possible users table in the db.  But which db?  Well... we'll want it in
the default db for obvious reasons.  But we'll also want it in the test db as well.  But testing
will routinely drop all the tables and rebuild them from scratch, as necessary and directed.  These amazing
facts lead us to "fixtures."  With fixtures we can provide the schema for the various tables, as well as 
some initial data to populate said tables.

However, if we describe the table schema in a fixture, we'll also have to eventually duplicate this schema
in the default db.  Keeping these two things in sync is a nuisance.  Fortunately we can have a fixture get
it's schema from the real db.  This will prove useful so that's what I'll do.

The first step in doing that is to create our table in the default db.  Perhaps like this...

```
CREATE  TABLE `cakephp-auth-tdd`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) );
```

Next, create a fixture that references the default db and include that fixture in the test.
Please see the source code for this.

<b>commit- 80dc1e.</b>  When we run the test now, it fails because "Model User cannot be found".

That's an easy one.  Let's create the User model.

<b>commit- 86fcd0.</b>  When we run the test now, it fails because it can't find 
the getAllUsers method of the model.

Let's create said method.

<b>commit- 842be6.</b>  When we run the test now, all is green!

The basic model testing is in place.  We have a users table in the default db,
a fixture that refers to it, a User model, a test for that model, and finally a test that calls the getAllUsers method.  Said method doesn't presently return anything, so let's fix
that.  Let modify the fixture to provide some data, the method to return the data,
and the test to compare what it received with what it expected.