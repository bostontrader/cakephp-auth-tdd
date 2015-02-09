<h1>The purpose of this repository is to assemble some useful
techniques into a starter installation of CakePHP.  Said techniques
include:</h1>

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