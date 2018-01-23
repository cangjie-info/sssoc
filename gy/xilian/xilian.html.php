<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../gy_styles.css" />
    <title>GY xilian</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #mynetwork {
            width: 1200px;
            height: 600px;
            border: 1px solid lightgray;
        }
    </style>
</head>
<body>
    <h2><span>Force directed graph visualization of the <i>xilian</i> 系聯 series for initial: 
        <?php echo($initial_name . ' ' . $initial_baxter . '-'); ?>
                </span></h2>
<div id="mynetwork"></div>
<script type="text/javascript">
    
    //set options
    var options = {
        edges: {
            arrows: {
                from: {enabled: true, scaleFactor: 0.5}
            }
        }
    };
    
    // create an array with nodes
    var nodes = new vis.DataSet( <?php echo json_encode($nodes); ?> );

    // create an array with edges
    var edges = new vis.DataSet( <?php echo json_encode($edges); ?> );

    // create a network
    var container = document.getElementById('mynetwork');

    // provide the data in the vis format
    var data = {
        nodes: nodes,
        edges: edges
    };

    // initialize your network!
    var network = new vis.Network(container, data, options);
</script>
</body>
</html>