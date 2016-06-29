
<?php

/*


Code Reviewer - Jonathan Raxa
Date Reviewed - May 4th, 2016 


In general this is a very, very well formatted document. You obviously seem to already know what you're doing. The only suggestion I would make is to comment the classes to explain very briefly what the class is used for, just to get an initial idea of what we're looking for in each class and its methods - in spite of the method names already giving that idea already. 

For instance when I see the class named "Clause" I wasn't quite sure what the class was being used for (just assuming that it's probably building something for me) until I really looked and saw that it really was creating something for me based on the arguments. Another example may be perhaps a comment as to why we needed an arrayToString method - not to say we don't need it but something to explain its use.

**As for each of our standards --> 

1) Distinct functions in separate classes (Search class, index (home))
    - perfect

2) Choose logical file & variable names.
    - perfect

3) Use jsbeautifier.org. Watch about impact on comments.
    - N/A

4) Use indenting of 4 spaces, Properly indent blocks
    - perfect

5) 2 blank lines between blocks. Eliminate excessive blank lines.
    - perfect

6)  Put large custom css blocks in separate files
    - N/A

7) Put comments for includes and for each block. Block comments are capitalized
    - As I mentioned above it would be nice to have the classes commented (see above for more details). 
    - The capitalization for block code is our team standard for php files with HTML for the sake of readability (debugging, etc). It's up to you if you find it necessary to comment your classes with all caps since it doesn't have any HTML in it.

 8) More than 2 group code review sessions to standardize pages
    - N/A

*/

// ANY KEYWORD ARRAY BECOMES A STRING 
function arrayToString($a) {
    $s = "[";
    if (count($a) > 0) {
        $s .= $a[0];
        for ($i = 1; $i < count($a); $i += 1) {
            $s .= ", ";
            $s .= $a[$i];
        }
    }
    $s .= "]";
    return $s;
}

// SEPARATES THE ARGUEMNTS INTO SPECIFIC KEYWORDS
class Clause {
    private $sql;
    private $arguments;
    private $argumentTypes;

    function __construct($sql, $arguments, $argumentTypes) {
        $this->sql = $sql;
        $this->arguments = $arguments;
        $this->argumentTypes = $argumentTypes;
    }

    public function getSQL() {
        return $this->sql;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function getArgumentTypes() {
        return $this->argumentTypes;
    }

    public static function join($operator, $clauses) {
        if (count($clauses) > 0) {
            $query = "";
            $arguments = array();
            $argumentTypes = array();

            $clause = $clauses[0];

            $query .= $clause->sql;

            $arguments = array_merge($arguments, $clause->arguments);
            $argumentTypes = array_merge($argumentTypes, $clause->argumentTypes);

            for ($i = 1; $i < count($clauses); $i += 1) {
                $clause = $clauses[$i];

                $query .= $operator;
                $query .= $clause->sql;

                $arguments = array_merge($arguments, $clause->arguments);
                $argumentTypes = array_merge($argumentTypes, $clause->argumentTypes);
            }
            return new Clause($query, $arguments, $argumentTypes);
        } else {
            // Empty clause
            return new Clause("", array(), array());
        }
    }
}

function keywordClause($keyword) {
    return new Clause("mk.keyword = ?", array($keyword), array("s"));
}

class ImageSearch {
    private $required;
    private $criteria;

    function __construct() {
        $this->required = array();
        $this->criteria = array();
    }

    public function addCriteria($clause) {
        array_push($this->criteria, $clause);
    }

    public function addRequiredCriteria($clause) {
        array_push($this->required, $clause);
    }

    public function prepare($connection) {
        $arguments = array();
        $argumentTypes = array();
        $query = "SELECT * FROM media ";
        $query .= "JOIN media_keywords AS mk ON mk.media = id ";

        if (count($this->criteria) > 0 || count($this->required) > 0) {
            $query .= "WHERE ";
        }

        if (count($this->criteria) > 0) {
            $query .= "(";

            $compositeClause = Clause::join(" OR ", $this->criteria);
            $query .= $compositeClause->getSQL();
            $arguments = array_merge($arguments, $compositeClause->getArguments());
            $argumentTypes = array_merge($argumentTypes, $compositeClause->getArgumentTypes());

            $query .= ")";
            if (count($this->required) > 0) {
                $query .= " AND ";
            }
        }

        if (count($this->required) > 0) {
            $compositeClause = Clause::join(" AND ", $this->required);
            $query .= $compositeClause->getSQL();
            $arguments = array_merge($arguments, $compositeClause->getArguments());
            $argumentTypes = array_merge($argumentTypes, $compositeClause->getArgumentTypes());
        }

        $query .= " GROUP BY id ORDER BY COUNT(id) DESC;";

        // NOTE: This is a gross hack around a bad API
        // We're building the argument list for bind_param
        $callArguments = array("");
        for ($i = 0; $i < count($arguments); $i+=1) {
            $callArguments[0] .= $argumentTypes[$i];
            $callArguments[] = &$arguments[$i];
        }

        $statement = $connection->prepare($query);

        // All because we can't use the splat operator...
        $mysqli_stmt = new ReflectionClass("mysqli_stmt");
        $bind_param = $mysqli_stmt->getMethod("bind_param");
        $bind_param->invokeArgs($statement, $callArguments); 

        return $statement;
    }
}

// Why PHP why?!
// Acts something like the result of $statement->get_result()
class ResultSet {
    private $statement;
    function __construct($statement) {
        $this->statement = $statement;
    }

    public function fetch_assoc() {
        // NOTE: could hoist some of this into constructor for performance
        $metadata = $this->statement->result_metadata();
        $callArguments = array(); // Something about PHP reference semantics seems to require this indirection
        $result = array();
        $fields = $metadata->fetch_fields();
        foreach ($fields as $field) {
            $result[$field->name] = NULL;
            $callArguments[] = &$result[$field->name];
        }
        $mysqli_stmt = new ReflectionClass("mysqli_stmt");
        $bind_param = $mysqli_stmt->getMethod("bind_result");
        $bind_param->invokeArgs($this->statement, $callArguments); 

        if ($this->statement->fetch()) {
            return $result;
        } else {
            return NULL;
        }
    }
}
?>
