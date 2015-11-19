<?php


require("dbconfig.php");
function printTable($data)
{
    // We're going to construct an HTML table.
    print "<div  class = \"resultTable\">";
    print "    <table id = \"resultTable\" border='1'>\n";

    // Construct the HTML table row by row.
    $printHeaderFlag = true;
    foreach ($data as $row) {
        // print header info
        if ($printHeaderFlag) {
            print "<tr>\n";
            foreach ($row as $name => $value) {
                print "<th>$name</th>\n";
            }
            print "</tr>\n";
            $printHeaderFlag = false;
        }

        // Data row.
        print "<tr>\n";
        foreach ($row as $name => $value) {
            print "<td>$value</td>\n";
        }
        print "</tr>\n";
    }

    print "</table>\n";
    print "</div>\n";
}

$name = filter_input(INPUT_POST, "MovieName");

print "<h1>Comments for $name</h1>";

try {

    // prepareStatement

    $query = "select Comment.Content, Comment.Name From Comment, Movie WHERE Movie.Name = :name And Comment.MovieID = Movie.ID";

    $ps = $con->prepare($query);
    $ps->execute(array(':name' => $name));
    $data = $ps->fetchAll(PDO::FETCH_ASSOC);


        if (count($data) > 0) {
            print "<div>\n";
            printTable($data);
            print "\n</div>\n";
        } else {
            print "<h2> Sorry... \"$name\" has not yet been reviewed</h2>\n";
        }


} catch (PDOException $e) {
    echo 'ERROR:' . $e->getMessage();

}
?>


</section>


</div>
</body>
</html>