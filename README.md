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

The basic model testing is now in place.  We have a users table in the default db,
a fixture that refers to it, a User model, a test for that model, and finally a test that calls the getAllUsers method.  Said method doesn't presently return anything, so let's fix
that.

At this point, theory bumps into reality.  The TDD purest would say "first build the test and watch it fail."  
We could do that.  And then watch as the test fails again on the next obvious stumbling block.  We could do this
several times as we work our way through the discovery that we need to modify the fixture to populate
the test db with data, as well as to modify the method to return the data.  This is too tedious so
in this step I'll combine all of that, saving us some time.

If you've been watching closely, I've already waved away a few bits of boiler code w/o bothering to
let our tests fail in their absence first.  In real-life we must balance the TDD theory with just get-it-done.
Moving forward, we'll frequently see this issue.

<b>commit- 5ed6f3.</b>  When we run the test now, all is green!  And this is how it should be.

Despite my irrational exuberance about doing things ahead of testing in the prior step, I did restrain
myself a bit.  If you look at the code now, you'll see that all of it conspires to support
merely a single field, id, in the User table.  I _could_ have earlier guessed at other fields it might
need in the future, but this is where it's easy to get carried away with adding lots of stuff.
We'll add these other fields when and if we ever need them.  Speaking of...

How about we live dangerously now and guess that <b>username, password, is_active,</b> and <b>is_admin</b>
Are reasonably likely to be useful and throw them in now.  As usual, our first order of business will
be to add a test that depends upon their existence.  In this case, we'll modify our single test
and then work our way through the resulting errors until we get to green again.

We'll have to modify our users table in the default db, perhaps thus...

```
ALTER TABLE `cakephp-auth-tdd`.`users` 
  ADD COLUMN `username` VARCHAR(255) NULL DEFAULT NULL  AFTER `id` , 
  ADD COLUMN `password` VARCHAR(255) NULL DEFAULT NULL  AFTER `username` , 
  ADD COLUMN `is_active` TINYINT(1) NULL DEFAULT 0  AFTER `password` , 
  ADD COLUMN `is_admin` TINYINT(1) NULL DEFAULT 0  AFTER `is_active` ;
```

<h3>3. The UsersController</h3>

Starting with <b>commit eb9a69</b> we implement step 3-1.  It's time to start in on the UsersController.  As we did with
the User model, we <i>could</i> pick this apart, tedious-step-by-tedious-step.  But now you we
have some experience and judgement, let's pick up the pace.

We start with the shell of a UsersControllerTest, which extends ControllerTestCase.  It doesn't
take long to discover that we need a UsersController, we need an index method, and said
method needs to invoke getAllUsers on the User model.

Starting with <b>commit 85228e</b> we implement step 3-2.  Now let's take a closer
look at our budding test. The first test was named <b>testIndex</b>. We might want to test that 
browsing to <b>/users</b> will by default invoke the <b>index</b> method on the <b>UsersController</b>.

But wait... I don't think so.  That's CakePHP's functionality and/or a matter of routing configuration.
Perhaps that should be tested elsewhere.  What I care about now is whether or not the <b>UsersController->index</b> 
method functions correctly, regardless of how it's invoked.

Now I make minimum modifications to get anything to render.  No need to fecth any data yet,
just get something simple to render.  The test invokes <b>testAction</b> and then... how do we 
conclude that the action was successful?  As you may know by now, there are several types of results
that <b>testAction</b> can return, depending upon the setting (or existence of) the <b>return</b> 
parameter when invoked.  In this case, I think we should specify <b>'return' => 'view'</b>.  
This will cause only the generated view to be returned, without any enclosing layout.  If we get a view, 
then we can conclude this test was successful.

As we work our way through TDD, we'll discover that we need to create a new folder <b>/Views/Users</b> and a
new file therein named <b>index.ctp</b>.

Starting with **commit c807d6** we implement **step 3-3.**

One of the big headaches in testing
is learning to understand and deal with the various levels and limits of testing that people talk about.
For example, right now we're doing "unit testing" of models and controllers.  Unit testing is supposed to
be confined to small and narrow pieces of code.  Such as the individual methods of a controller. But it's certainly not the same as integration testing, which watches to see how several
pieces work together.

In testing our controller, I come to the conclusion that there's really not much more to test at this
point, within the bounds of unit-testing.  After all, the controller method is invoked and in so doing
seems to cause a view to be produced.  This in itself smells like some integration testing, but I'll
ignore that.

The heart of our controller testing is the **testAction** method.  This method can be configured to
return four possibly interesting things about the results of invoking a controller method.
They are:

* result
* vars
* view
* content

Is there anything about these things that are particularly
useful at this point?

**result** is whatever the controller explicitly returns.  This would be useful if we were actually
sending back results, such as JSON, or dealing with redirects.  But at this time, it's not useful to us.

**vars** is whatever vars were "set" before the view was rendered.  This doesn't sound very useful,
except to possibly test CakePHP functionality itself.  If we set some vars, we expect Cake will 
do its job and deliver them.  How is testing that useful to us now?

**view** is the most promising.  This lets us see the actual view that was rendered, minus the
layout.  However, picking
this apart is not the job of the controller's unit testing.  Nevertheless, we may want to 
take a closer look at this shortly.

**content** is the entire page that was rendered, layout plus view.  Whatever the rest of the layout looks
like is certainly far afield of controller unit testing, and we already have the view, so this
doesn't look very useful.

"That's all fine and dandy" you say, but you still have software to build?  We can agonize over these
principals forever but we still have to make some code.  How shall we find some practical usage?

I say we live dangerously and color outside the lines.  The fact is, we _can_ pick apart a view
using our controller unit test and this is good enough for now.  I think that it's better to keep moving using
theoretically defective methods than to grind to a halt in a futile search for perfection.  When and if
your project gets so big and complex that our simple methods fail to scale, then you'll have
to do some re-thinking then.  Until then, let's keep it simple.

So, let's modify the test to examine the view for a table element.  The table won't have anything in it
but it's a humble beginning.

Starting with **commit d66186** we implement **step 3-4.**

In this step I want to feed the **index** method a known quantity of User records and then 
examine the rendered view to find a table that has that many rows.  At this time, there's
no header-row in the table nor any columns.  Only empty rows that we can count. But how shall
we count these rows?  

To make a long story short, I'll merely assert that regex quickly falls
apart when you try to do things like this.  Fortunately, there's a handy little lump
of code called **simple\_html_dom** that eats this alive.  It parses the html code we give it,
like the view that Cake just generated, and let's us work with the structure therein. 
So if we need to find a table that contains a known quantity of rows, that's not a problem.

In keeping this simple, I've chosen to put the
**simple\_html_dom** file in the same directory that the UsersController test is in.  Doing
so make using require_once so much easier and until such time as other code needs access, if ever, this is good enough.

Starting with **commit 512dd6** we implement **step 3-5.**

The test at this point only counts the rows of an unspecified table.  Which table?  Probably the first table it finds.
This test is a bit fragile.  If we ever add another table, then the test will probably fail. 
If we ever add new rows, such as for headers, then the test will fail.  

The Cake documentation
itself warns against picking apart views as part of testing.  It suggests integration testing using
tools such as Selenium WebDriver.  Nevertheless, examining the resulting view is an excellent method
of determining if the controller is working as expected.  So I think there's a happy medium to be had.

That said, let's modify the test and view so that:

* The <table> is tagged as id=users
* The <table> has a <tbody> section
* The test only counts the rows in the <tbody> section


Starting with **commit 07c475** we implement **step 3-6.**

Now I want to modify the test and view so that:

* The <table> has a <thead> section
* The single <tr> in the <thead> section contains <td> elements for the id and username columns
* The rows in the <tbody> section contain <td> elements for the id and username, which match what was feed to it from the fixture.

I had to modify the source for **simple\_html_dom** because of a bizarre error that I was getting.
For some reason it was ignoring <tbody> elements.  I commented out a single line of code and the
test passes now.


Starting with **commit 3e5898** we implement **step 3-7.**

Now it's time for a pop-quiz.  Let's modify whatever needs modifying to add the **is_active** and **is_admin**
fields.  

In doing so we discover another bizarre error.  For whatever reason, when attempting to display a 0 in any of these fields, the view will only render a space instead.  Why?  Why not.  Just hack it a be done with it.


Starting with **commit 2cc420** we implement **step 3-8.**

The astute observer will have noticed that I skipped the password field.  I'll return to that shortly, but for now I think we've beaten the **index** horse enough so next I want to flesh out the other methods (add, edit, view, and delete).  In this step, let's look at the **view** method.

Now that we know how to do the TDD dance, it's pretty easy to discover that we need:

* A **view** method in the **UsersController**
* A test in **UsersControllerTest**
* A view named **/View/Users/view.ctp**
 
In this first draft, I only want to test the correct operation of all this.  I don't want to try to confuse anything by POSTing to it, or GETing without a valid $id or anything like that.

One nettlesome wrinkle I discovered in this step is that the ids are assigned using an auto-increment field that starts with 1, but the array of user fixture records use zero-based indexing.  Therefore the id number used by the view URL will be 1 higher than the index for the corresponding record in the array of user fixture records.