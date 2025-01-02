<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Tree Diagram</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background-color: #f8f9fa;
        }

        svg {
            width: 100%;
            height: 100%;
        }

        .node circle {
            fill: #fff;
            stroke: steelblue;
            stroke-width: 3px;
            cursor: pointer;
            transition: fill 0.3s ease;
        }

        .node.collapsed circle {
            fill: steelblue;
        }

        .node:hover circle {
            stroke: #2c5282;
        }

        .node text {
            font: 14px sans-serif;
            pointer-events: none;
        }

        .link {
            fill: none;
            stroke: #ccc;
            stroke-width: 2px;
        }

        .controls {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 8px 16px;
            background: #4299e1;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 8px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2b6cb0;
        }

        .instructions {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="controls">
            <button id="reset">Reset View</button>
            <button id="zoomIn">Zoom In</button>
            <button id="zoomOut">Zoom Out</button>
            <button id="expandAll">Expand All</button>
            <button id="collapseAll">Collapse All</button>
        </div>
        <div class="instructions">
            🖱️ Mouse wheel to zoom<br>
            ✋ Click and drag to pan<br>
            👆 Click nodes to expand/collapse
        </div>
        <svg></svg>
    </div>

    <script>
        const data = {
            name: "U",
            children: [
                {
                    name: "A"
                },
                {
                    name: "B",
                    children: [
                        {
                            name: "A",
                            children: [
                                { name: "A" },
                                { name: "B" }
                            ]
                        },
                        { name: "B" }
                    ]
                }
            ]
        };

        let root;
        const width = window.innerWidth;
        const height = window.innerHeight;
        const margin = { top: 60, right: 40, bottom: 50, left: 40 };
        const duration = 750;

        const svg = d3.select("svg");
        const g = svg.append("g");

        const zoom = d3.zoom()
            .scaleExtent([0.1, 4])
            .on("zoom", (event) => {
                g.attr("transform", event.transform);
            });

        svg.call(zoom);

        const tree = d3.tree()
            .nodeSize([60, 80]);

        // Creates the tree data structure and assigns parent/children relationships
        function createTree() {
            root = d3.hierarchy(data);
            root.x0 = 0;
            root.y0 = 0;
            root.descendants().forEach((d, i) => {
                d.id = i;
                d._children = d.children;
            });
        }

        // Updates the tree visualization
        function update(source) {
            const nodes = root.descendants();
            const links = root.links();

            // Compute the new tree layout
            tree(root);

            const transition = svg.transition()
                .duration(duration);

            // Update the nodes
            const node = g.selectAll(".node")
                .data(nodes, d => d.id);

            // Enter new nodes at the parent's previous position
            const nodeEnter = node.enter().append("g")
                .attr("class", "node")
                .attr("transform", d => `translate(${source.x0},${source.y0})`)
                .on("click", (event, d) => {
                    if (event.defaultPrevented) return;
                    event.preventDefault();
                    if (d.children) {
                        d._children = d.children;
                        d.children = null;
                    } else {
                        d.children = d._children;
                        d._children = null;
                    }
                    update(d);
                });

            nodeEnter.append("circle")
                .attr("r", 10)
                .style("fill", d => d._children ? "steelblue" : "#fff");

            nodeEnter.append("text")
                .attr("dy", "0.35em")
                .attr("x", d => d._children || d.children ? 20 : -20)
                .attr("text-anchor", d => d._children || d.children ? "start" : "end")
                .text(d => d.data.name);

            // Update existing nodes
            const nodeUpdate = node.merge(nodeEnter)
                .transition(transition)
                .attr("transform", d => `translate(${d.x},${d.y})`);

            nodeUpdate.select("circle")
                .style("fill", d => d._children ? "steelblue" : "#fff");

            // Remove exiting nodes
            const nodeExit = node.exit()
                .transition(transition)
                .attr("transform", d => `translate(${source.x},${source.y})`)
                .remove();

            nodeExit.select("circle")
                .attr("r", 0);

            // Update the links
            const link = g.selectAll(".link")
                .data(links, d => d.target.id);

            // Enter new links at parent's previous position
            const linkEnter = link.enter().insert("path", "g")
                .attr("class", "link")
                .attr("d", d => {
                    const o = { x: source.x0, y: source.y0 };
                    return d3.linkVertical()({
                        source: o,
                        target: o
                    });
                });

            // Update existing links
            link.merge(linkEnter)
                .transition(transition)
                .attr("d", d3.linkVertical()
                    .x(d => d.x)
                    .y(d => d.y));

            // Remove exiting links
            link.exit()
                .transition(transition)
                .attr("d", d => {
                    const o = { x: source.x, y: source.y };
                    return d3.linkVertical()({
                        source: o,
                        target: o
                    });
                })
                .remove();

            // Store the old positions for transition
            nodes.forEach(d => {
                d.x0 = d.x;
                d.y0 = d.y;
            });
        }

        function expandAll() {
            root.descendants().forEach(d => {
                if (d._children) {
                    d.children = d._children;
                    d._children = null;
                }
            });
            update(root);
        }

        function collapseAll() {
            root.descendants().forEach(d => {
                if (d.children && d.depth > 0) {
                    d._children = d.children;
                    d.children = null;
                }
            });
            update(root);
        }

        // Initialize the tree
        createTree();

        // Center the tree initially
        const initialTransform = d3.zoomIdentity
            .translate(width / 2, margin.top);
        svg.call(zoom.transform, initialTransform);

        update(root);

        // Control button functionality
        d3.select("#reset").on("click", () => {
            svg.transition()
                .duration(750)
                .call(zoom.transform, initialTransform);
        });

        d3.select("#zoomIn").on("click", () => {
            svg.transition()
                .duration(750)
                .call(zoom.scaleBy, 1.3);
        });

        d3.select("#zoomOut").on("click", () => {
            svg.transition()
                .duration(750)
                .call(zoom.scaleBy, 0.7);
        });

        d3.select("#expandAll").on("click", expandAll);
        d3.select("#collapseAll").on("click", collapseAll);

        // Handle window resizing
        window.addEventListener('resize', () => {
            const width = window.innerWidth;
            const height = window.innerHeight;
            svg.attr('width', width).attr('height', height);
            update(root);
        });
    </script>
</body>

</html>