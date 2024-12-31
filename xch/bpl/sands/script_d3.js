function drawOrganizationChart(params) {
    const attrs = {
        EXPAND_SYMBOL: "\uf067",
        COLLAPSE_SYMBOL: "\uf068",
        selector: params.selector,
        root: params.data,
        width: params.chartWidth,
        height: params.chartHeight,
        index: 0,
        nodePadding: 9,
        collapseCircleRadius: 7,
        nodeHeight: 80,
        nodeWidth: 160,
        duration: 750,
        rootNodeTopMargin: 20,
        minMaxZoomProportions: [0.05, 3],
        linkLineSize: 180,
        collapsibleFontSize: "10px",
        userIcon: "\uf013",
        nodeStroke: "green",
        nodeStrokeWidth: "1px"
    };

    const dynamic = {};

    dynamic.nodeImageWidth = attrs.nodeHeight * 100 / 140;
    dynamic.nodeImageHeight = attrs.nodeHeight - 2 * attrs.nodePadding;
    dynamic.nodeTextLeftMargin = attrs.nodePadding * 2 + dynamic.nodeImageWidth;
    dynamic.rootNodeLeftMargin = attrs.width / 2;
    dynamic.nodePositionNameTopMargin = attrs.nodePadding + 8 + dynamic.nodeImageHeight / 4;
    dynamic.nodeChildCountTopMargin = attrs.nodePadding + 14 + dynamic.nodeImageHeight / 4 * 3;

    const tree = d3.layout.tree().nodeSize([attrs.nodeWidth + 40, attrs.nodeHeight]);
    const diagonal = d3.svg.diagonal()
        .projection(function (d) {
            debugger;
            return [d.x + attrs.nodeWidth / 2, d.y + attrs.nodeHeight / 2];
        });
    const zoomBehaviours = d3.behavior
        .zoom()
        .scaleExtent(attrs.minMaxZoomProportions)
        .on("zoom", redraw);
    const svg = d3.select(attrs.selector)
        .append("svg")
        .attr("width", attrs.width)
        .attr("height", attrs.height)
        .call(zoomBehaviours)
        .append("g")
        .attr("transform", "translate(" + (attrs.width / 2 - 190) + "," + 20 + ")");

    //necessary so that zoom knows where to zoom and un-zoom from
    zoomBehaviours.translate([dynamic.rootNodeLeftMargin, attrs.rootNodeTopMargin]);

    attrs.root.x0 = 0;
    attrs.root.y0 = dynamic.rootNodeLeftMargin;

    if (params.mode !== "department") {
        // adding unique values to each node recursively
        let uniq = 1;

        addPropertyRecursive("uniqueIdentifier", function () {
            return uniq++;
        }, attrs.root);
    }

    expand(attrs.root);

    if (attrs.root.children) {
        attrs.root.children.forEach(collapse);
    }

    update(attrs.root);

    d3.select(attrs.selector).style("height", attrs.height);

    function update(source, param) {

        // Compute the new tree layout.
        const nodes = tree.nodes(attrs.root)
                .reverse(),
            links = tree.links(nodes);

        // Normalize for fixed-depth.
        nodes.forEach(function (d) {
            d.y = d.depth * attrs.linkLineSize;
        });

        // Update the nodes…
        const node = svg.selectAll("g.node")
            .data(nodes, function (d) {
                return d.id || (d.id = ++attrs.index);
            });

        // Enter any new nodes at the parent's previous position.
        const nodeEnter = node.enter()
            .append("g")
            .attr("class", "node")
            .attr("transform", function () {
                return "translate(" + source.x0 + "," + source.y0 + ")";
            });

        const nodeGroup = nodeEnter.append("g")
            .attr("class", "node-group");

        nodeGroup.append("rect")
            .attr("width", attrs.nodeWidth)
            .attr("height", attrs.nodeHeight)
            .attr("data-node-group-id", function (d) {
                return d.uniqueIdentifier;
            })
            .attr("class", function (d) {
                let res = "";
                if (d.isLoggedUser) res += "nodeRepresentsCurrentUser ";
                res += d._children || d.children ? "nodeHasChildren" : "nodeDoesNotHaveChildren";

                return res;
            });

        const collapsiblesWrapper =
            nodeEnter.append("g")
                .attr("data-id", function (v) {
                    return v.uniqueIdentifier;
                });

        const collapsibles = collapsiblesWrapper.append("circle")
            .attr("class", "node-collapse")
            .attr("cx", attrs.nodeWidth - attrs.collapseCircleRadius)
            .attr("cy", attrs.nodeHeight - 7)
            .attr("", setCollapsibleSymbolProperty);

        //hide collapse rect when node does not have children
        collapsibles.attr("r", function (d) {
            if (d.children || d._children) return attrs.collapseCircleRadius;

            return 0;
        })
            .attr("height", attrs.collapseCircleRadius);

        collapsiblesWrapper.append("text")
            .attr("class", "text-collapse")
            .attr("x", attrs.nodeWidth - attrs.collapseCircleRadius)
            .attr("y", attrs.nodeHeight - 3)
            .attr("width", attrs.collapseCircleRadius)
            .attr("height", attrs.collapseCircleRadius)
            .style("font-size", attrs.collapsibleFontSize)
            .attr("text-anchor", "middle")
            .style("font-family", "FontAwesome")
            .text(function (d) {
                return d.collapseText;
            });

        collapsiblesWrapper.on("click", click);

        nodeGroup.append("text")
            .attr("x", dynamic.nodeTextLeftMargin)
            .attr("y", attrs.nodePadding + 10)
            .attr("class", "emp-name")
            .attr("text-anchor", "left")
            .text(function (d) {
                return d.username.trim();
            })
            .call(wrap, attrs.nodeWidth);

        nodeGroup.append("text")
            .attr("x", dynamic.nodeTextLeftMargin)
            .attr("y", dynamic.nodePositionNameTopMargin)
            .attr("class", "emp-position-name")
            .attr("dy", ".15em")
            .attr("text-anchor", "left")
            .text(function (d) {
                return d.account;
            });

        nodeGroup.append("text")
            .attr("x", dynamic.nodeTextLeftMargin)
            .attr("y", attrs.nodePadding + 10 + dynamic.nodeImageHeight / 4 * 2)
            .attr("class", "emp-position-name")
            .attr("dy", "0.05em")
            .attr("text-anchor", "left")

            .text(function (d) {
                return d.income_cycle;
            });

        nodeGroup.append("text")
            .attr("x", dynamic.nodeTextLeftMargin)
            .attr("y", dynamic.nodeChildCountTopMargin)
            .attr("class", "emp-position-name")
            .attr("dy", "-0.2em")
            .attr("text-anchor", "left")

            .text(function (d) {
                return d.caption === "Y" ? "Active" : "Inactive";
            });

        nodeGroup.append("defs").append("svg:clipPath")
            .attr("id", "clip")
            .append("svg:rect")
            .attr("id", "clip-rect")
            .attr("rx", 3)
            .attr("x", attrs.nodePadding)
            .attr("y", 2 + attrs.nodePadding)
            .attr("width", dynamic.nodeImageWidth)
            .attr("fill", "none")
            .attr("height", dynamic.nodeImageHeight - 4);

        nodeGroup.append("svg:image")
            .attr("y", 2 + attrs.nodePadding)
            .attr("x", attrs.nodePadding)
            .attr("preserveAspectRatio", "yes")
            .attr("width", dynamic.nodeImageWidth)
            .attr("height", dynamic.nodeImageHeight - 4)
            .attr("clip-path", "url(#clip)")
            .attr("xlink:href", function () {
                return params.imageUrl;
            });

        // Transition nodes to their new position.
        const nodeUpdate = node.transition()
            .duration(attrs.duration)
            .attr("transform", function (d) {
                return "translate(" + d.x + "," + d.y + ")";
            });

        //todo replace with attrs object
        nodeUpdate.select("rect")
            .attr("width", attrs.nodeWidth)
            .attr("height", attrs.nodeHeight)
            .attr("rx", 3)
            .attr("stroke", function (d) {
                if (param && d.uniqueIdentifier === param.locate) {
                    return "#a1ceed";
                }

                return attrs.nodeStroke;
            })
            .attr("stroke-width", function (d) {
                if (param && d.uniqueIdentifier === param.locate) {
                    return 6;
                }

                return attrs.nodeStrokeWidth
            });

        // Transition exiting nodes to the parent's new position.
        const nodeExit = node.exit().transition()
            .duration(attrs.duration)
            .attr("transform", function () {
                return "translate(" + source.x + "," + source.y + ")";
            })
            .remove();

        nodeExit.select("rect")
            .attr("width", attrs.nodeWidth)
            .attr("height", attrs.nodeHeight);

        // Update the links…
        const link = svg.selectAll("path.link")
            .data(links, function (d) {
                return d.target.id;
            });

        // Enter any new links at the parent's previous position.
        link.enter().insert("path", "g")
            .attr("class", "link")
            .attr("x", attrs.nodeWidth / 2)
            .attr("y", attrs.nodeHeight / 2)
            .attr("d", function () {
                const o = {
                    x: source.x0,
                    y: source.y0
                };

                return diagonal({
                    source: o,
                    target: o
                });
            });

        // Transition links to their new position.
        link.transition()
            .duration(attrs.duration)
            .attr("d", diagonal);

        // Transition exiting nodes to the parent's new position.
        link.exit().transition()
            .duration(attrs.duration)
            .attr("d", function () {
                const o = {
                    x: source.x,
                    y: source.y
                };

                return diagonal({
                    source: o,
                    target: o
                });
            })
            .remove();

        // Stash the old positions for transition.
        nodes.forEach(function (d) {
            d.x0 = d.x;
            d.y0 = d.y;
        });

        let x = 0;
        let y = 0;

        if (param && param.locate) {
            nodes.forEach(function (d) {
                if (d.uniqueIdentifier === param.locate) {
                    x = d.x;
                    y = d.y;
                }
            });

            // normalize for width/height
            normalize(x, y);
        }

        if (param && param.centerMySelf) {
            nodes.forEach(function (d) {
                if (d.isLoggedUser) {
                    x = d.x;
                    y = d.y;
                }
            });

            // normalize for width/height
            normalize(x, y);
        }
    }

    function normalize(x, y) {
        let new_x = window.innerWidth / 2 - x;
        let new_y = window.innerHeight / 2 - y;

        // move the main container g
        svg.attr("transform", "translate(" + new_x + "," + new_y + ")");
        zoomBehaviours.translate([new_x, new_y]);
        zoomBehaviours.scale(1);
    }

    // Toggle children on click.
    function click(d) {
        d3.select(this).select("text").text(function (dv) {
            if (dv.collapseText === attrs.EXPAND_SYMBOL) {
                dv.collapseText = attrs.COLLAPSE_SYMBOL
            } else {
                if (dv.children) {
                    dv.collapseText = attrs.EXPAND_SYMBOL
                }
            }

            return dv.collapseText;
        });

        if (d.children) {
            d._children = d.children;
            d.children = null;
        } else {
            d.children = d._children;
            d._children = null;
        }

        update(d);
    }

    //########################################################

    //Redraw for zoom
    function redraw() {
        svg.attr("transform", "translate(" + d3.event.translate + ")" + " scale(" + d3.event.scale + ")");
    }

    // #############################   Function Area #######################
    function wrap(text, width) {
        text.each(function () {
            let text = d3.select(this),
                words = text.text().split(/\s+/).reverse(),
                word,
                line = [],
                lineNumber = 0,
                lineHeight = 1.1, // ems
                x = text.attr("x"),
                y = text.attr("y"),
                dy = 0,
                tspan = text.text(null)
                    .append("tspan")
                    .attr("x", x)
                    .attr("y", y)
                    .attr("dy", dy + "em");

            while (word = words.pop()) {
                line.push(word);
                tspan.text(line.join(" "));

                if (tspan.node().getComputedTextLength() > width) {
                    line.pop();
                    tspan.text(line.join(" "));
                    line = [word];
                    tspan = text.append("tspan")
                        .attr("x", x)
                        .attr("y", y)
                        .attr("dy", ++lineNumber * lineHeight + dy + "em")
                        .text(word);
                }
            }
        });
    }

    function addPropertyRecursive(propertyName, propertyValueFunction, element) {
        if (element[propertyName]) {
            element[propertyName] = element[propertyName] + ' ' + propertyValueFunction(element);
        } else {
            element[propertyName] = propertyValueFunction(element);
        }

        if (element.children) {
            element.children.forEach(function (v) {
                addPropertyRecursive(propertyName, propertyValueFunction, v)
            })
        }

        if (element._children) {
            element._children.forEach(function (v) {
                addPropertyRecursive(propertyName, propertyValueFunction, v)
            })
        }
    }

    function expand(d) {
        if (d.children) {
            d.children.forEach(expand);
        }

        if (d._children) {
            d.children = d._children;
            d.children.forEach(expand);
            d._children = null;
        }

        if (d.children) {
            // if node has children and it's expanded, then  display -
            setToggleSymbol(d, attrs.COLLAPSE_SYMBOL);
        }
    }

    function collapse(d) {
        if (d._children) {
            d._children.forEach(collapse);
        }

        if (d.children) {
            d._children = d.children;
            d._children.forEach(collapse);
            d.children = null;
        }

        if (d._children) {
            // if node has children and it's collapsed, then  display +
            setToggleSymbol(d, attrs.EXPAND_SYMBOL);
        }
    }

    function setCollapsibleSymbolProperty(d) {
        if (d._children) {
            d.collapseText = attrs.EXPAND_SYMBOL;
        } else if (d.children) {
            d.collapseText = attrs.COLLAPSE_SYMBOL;
        }
    }

    function setToggleSymbol(d, symbol) {
        d.collapseText = symbol;
        d3.select("*[data-id=\"" + d.uniqueIdentifier + "\"]").select("text").text(symbol);
    }
}