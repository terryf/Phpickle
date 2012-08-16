
Phpickle is a set of PHP classes that allow you to read (and in the future, write) the python pickle format. 

Currently only reading is supported and class based items are pretty much ignored, but lists, tuples, dicts and simpler data types should be supported.

==============Basic usage:

----
require_once "phpickle.php";

$data = phpickle::loads($pickled_string);
---

If you want to unpickle from something that can be treated as a php stream, then:


----
require_once "phpickle.php";

$data = phpickle::load_stream("pickled_file.pickle");
$data = phpickle::load_stream("http://www.pickler.com/mydata");
// and others
---


If you want to unpickle data that was stored by the default django session handler, then:

----
require_once "phpickle.php";

$data = phpickle::loads_django_session($data_from_django_session_db);
---


===============Current status:

Well, unpickling simple types, lists, tuples, dicts, ints, strings works, except double right now. Workging on that one. 
Also, classes are not quite there and of course, referencing any python specific things does not work. 

Pickling is not done at all, but should be possible for at least simple types. 


===============Code setup:

tests folder has phpunit based tests for some of the modules. 

Pickle is a very simple stack based language, the interpreter is in phpickle_unpickle.php 
and the read/write handlers for different opcodes are in the phpickle_op_handlers.pck. To generate 
the interpreter files, run make gen, that will generate phpickle_gen_read_ops.php and phpickle_gen_write_ops.php

To debug unpickling, call phpickle_unpickler->set_debug(true) and in the read jandler code, just to if ($debug). 
In the handler code, you can read data from the $stream, using phpickle_stream methods and push results into $stack
that is a phpickle_stack instance. $memo is for memorizing things. 
