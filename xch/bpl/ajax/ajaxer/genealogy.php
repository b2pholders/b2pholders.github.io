<?php

namespace BPL\Ajax\Ajaxer\Genealogy;

/**
 * Generates the complete HTML, CSS, and JavaScript for the genealogy visualization.
 *
 * This function serves as the entry point for rendering the genealogy tree. It combines
 * the HTML structure, CSS styles, and JavaScript code (including the AJAX request) into
 * a single string that can be output to the browser.
 *
 * @param string $type The type of genealogy tree (e.g., 'binary_pair', 'unilevel').
 * @param int $user_id The ID of the user for whom the tree is being generated.
 * @param string $plan The plan type (e.g., 'binary_pair', 'unilevel').
 *
 * @return string The complete HTML, CSS, and JavaScript code for the visualization.
 */
function main($type, $user_id, string $plan = 'binary_pair'): string
{
    $render = render($type, $user_id, $plan);

    return <<<HTML
        <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto'>
        <style>
            :root {
                --color-primary: steelblue;
                --color-secondary: #999;
                --color-background: #fff;
                --color-tooltip-bg: rgba(0, 0, 0, 0.9);
                --color-tooltip-text: #fff;
                
                --font-size-base: clamp(0.75rem, 2vw, 1rem);
                --font-family-base: system-ui, -apple-system, sans-serif;
                
                --spacing-sm: max(0.3125rem, 1vw);
                --spacing-md: max(0.625rem, 2vw);
                --spacing-top: max(2rem, 4vw);
                
                --border-radius: 0.3125rem;
                --stroke-width-large: min(3px, 0.5vw);
                --stroke-width-small: min(2px, 0.3vw);
                --border-dash-size: max(5px, 1vw);
                
                --transition-default: 200ms ease;
            }

            #genealogy_{$type} {
                width: 100%;
                height: 100vh;
                max-height: 100vh;
                overflow: hidden;
                position: relative;
                padding-top: var(--spacing-top);
                touch-action: none; /* Disable browser's default touch handling */
                -webkit-user-select: none; /* Prevent text selection during drag */
                user-select: none;
            }

            #genealogy_{$type} svg {
                width: 100% !important;
                height: calc(100% - var(--spacing-top)) !important;
                max-width: 100vw;
                max-height: 100vh;
            }

            /* Tooltip Styles */
            .tooltip {
                position: absolute;
                padding: 10px;
                background: var(--color-tooltip-bg);
                color: var(--color-tooltip-text);
                border-radius: 4px;
                font-size: 14px;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.2s ease-in-out;
                z-index: 1000;
                max-width: 300px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }

            /* Mobile Tooltip Positioning */
            @media (max-width: 768px) {
                .tooltip {
                    position: fixed;
                    left: 50% !important;
                    bottom: 20px !important;
                    transform: translateX(-50%);
                    top: auto !important;
                    width: 90%;
                    max-width: none;
                }
            }

            .tooltip div {
                margin: 5px 0;
                line-height: 1.4;
            }

            .tooltip strong {
                color: #fff;
                margin-right: 5px;
            }

            /* Border container */
            .border-container {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                pointer-events: none;
                border: var(--stroke-width-small) dashed var(--color-secondary);
                margin: var(--spacing-sm);
                border-radius: var(--border-radius);
            }

            #genealogy_{$type} .node circle {
                fill: var(--color-background);
                stroke: var(--color-primary);
                stroke-width: var(--stroke-width-large);
            }

            #genealogy_{$type} .node text {
                font: var(--font-size-base) var(--font-family-base);
                transform-origin: center;
            }

            #genealogy_{$type} .link {
                fill: none;
                stroke: var(--color-secondary);
                stroke-width: var(--stroke-width-small);
            }
        </style>
        <div id="genealogy_{$type}">
            <div class="border-container"></div>
        </div>
        <div class="tooltip" id="tooltip"></div>
        <div class="controls">
            <button class="control-button" id="zoomIn">+</button>
            <button class="control-button" id="zoomOut">-</button>
            <button class="control-button" id="reset">↺</button>
        </div>
        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script>{$render}</script>
    HTML;
}

/**
 * Generates the JavaScript code for making an AJAX request to fetch genealogy data.
 *
 * This function creates a jQuery AJAX call to fetch data for the genealogy tree based on
 * the specified type, user ID, and plan. The fetched data is then used to initialize the
 * tree visualization.
 *
 * @param string $type The type of genealogy tree (e.g., 'binary_pair', 'unilevel').
 * @param int $user_id The ID of the user for whom the tree is being generated.
 * @param string $plan The plan type (e.g., 'binary_pair', 'unilevel').
 *
 * @return string The JavaScript code for the AJAX request.
 */
function ajax($type, $user_id, string $plan = 'binary_pair'): string
{
    return <<<JS
        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: "bpl/ajax/action.php",
            data: {
                "action": "genealogy_{$type}",
                "id_user": {$user_id},
                "plan": "{$plan}"
            },
            success: function (data) {
                const treeVis = new TreeVisualization("#genealogy_{$type}", data);
            }
        });
    JS;
}

/**
 * Renders the HTML, CSS, and JavaScript for the genealogy visualization.
 *
 * This function generates the necessary HTML structure, CSS styles, and JavaScript code
 * for rendering a genealogy tree using D3.js. It also includes a tooltip for displaying
 * node details and handles AJAX requests for fetching tree data.
 *
 * @param string $type The type of genealogy tree (e.g., 'binary_pair', 'unilevel').
 * @param int $user_id The ID of the user for whom the tree is being generated.
 * @param string $plan The plan type (e.g., 'binary_pair', 'unilevel').
 *
 * @return string The complete HTML, CSS, and JavaScript code for the visualization.
 */
function render($type, $user_id, $plan): string
{
    // Generate the tooltip content
    $tooltipContent = tooltipContent($plan);

    $str = <<<JS
        /**
         * Type definition for a node in the tree structure.
         * Each node can have a name, optional details, and optional child nodes.
         * @typedef {Object} TreeNode
         * @property {string} name - Display name of the node
         * @property {Object} [details] - Optional metadata about the node
         * @property {string} details.id - Unique identifier
         * @property {string} details.account - Account information
         * @property {number} details.balance - Account balance
         * @property {string} details.plan - Subscription plan type
         * @property {number} details.bonus_indirect_referral - Bonus amount
         * @property {TreeNode[]} [children] - Array of child nodes
        */
        
        /**
         * Global configuration object for customizing the tree visualization.
         * Contains settings for margins, node appearance, animations, and link styling.
         * @constant {Object}
        */
        const CONFIG = {
            margin: {
                top: 20,     // Top margin in pixels
                right: 90,   // Right margin in pixels
                bottom: 30,  // Bottom margin in pixels
                left: 90     // Left margin in pixels
            },
            nodeRadius: 10,              // Radius of node circles in pixels
            transitionDuration: 200,     // Duration of animations in milliseconds
            linkStyle: {
                strokeWidth: 2,          // Width of connecting lines
                strokeColor: "#999"      // Color of connecting lines
            }
        };
        
        /**
         * Class representing an interactive tree visualization using D3.js
         * Features include:
         * - Collapsible nodes
         * - Interactive zooming
         * - Tooltips with node details
         * - Smooth transitions
         * - Automatic layout
        */
        class TreeVisualization {
            /**
             * Creates a new tree visualization instance
             * @param {string} containerId - ID of the DOM element to contain the tree
             * @param {TreeNode} data - Hierarchical data structure for the tree
            */
            constructor(containerId, data) {
                this.i = 0;
                this.container = d3.select(containerId);
                
                this.updateDimensions();
                this.initializeResizeHandler();
                
                // Touch interaction state
                this.touchState = {
                    isDragging: false,
                    lastX: 0,
                    lastY: 0,
                    startX: 0,
                    startY: 0,
                    transform: null
                };
                
                this.tooltip = d3.select("#tooltip");
                this.initialVerticalOffset = 60;
                
                this.initializeSVG();
                this.initializeTree(data);
                this.setupZoom();
                this.setupControls();
                this.setupTouchInteractions();
            }

            setupTouchInteractions() {
                const container = this.container.node();
                
                // Touch start handler
                container.addEventListener('touchstart', (e) => {
                    if (e.touches.length === 1) {
                        // Single touch - initialize drag
                        const touch = e.touches[0];
                        this.touchState.isDragging = true;
                        this.touchState.lastX = touch.clientX;
                        this.touchState.lastY = touch.clientY;
                        this.touchState.startX = touch.clientX;
                        this.touchState.startY = touch.clientY;
                        this.touchState.transform = d3.zoomTransform(this.svg.node());
                    } else if (e.touches.length === 2) {
                        // Two touches - prepare for pinch zoom
                        this.touchState.isDragging = false;
                        const touch1 = e.touches[0];
                        const touch2 = e.touches[1];
                        this.touchDistance = Math.hypot(
                            touch2.clientX - touch1.clientX,
                            touch2.clientY - touch1.clientY
                        );
                    }
                }, { passive: true });

                // Touch move handler
                container.addEventListener('touchmove', (e) => {
                    if (e.touches.length === 1 && this.touchState.isDragging) {
                        // Handle drag
                        const touch = e.touches[0];
                        const dx = touch.clientX - this.touchState.lastX;
                        const dy = touch.clientY - this.touchState.lastY;
                        
                        // Update last position
                        this.touchState.lastX = touch.clientX;
                        this.touchState.lastY = touch.clientY;
                        
                        // Calculate new transform
                        const transform = this.touchState.transform;
                        const newTransform = transform.translate(
                            dx / transform.k,
                            dy / transform.k
                        );
                        
                        // Apply the new transform
                        this.svg.call(
                            this.zoom.transform,
                            newTransform
                        );
                    } else if (e.touches.length === 2) {
                        // Handle pinch zoom
                        const touch1 = e.touches[0];
                        const touch2 = e.touches[1];
                        const newDistance = Math.hypot(
                            touch2.clientX - touch1.clientX,
                            touch2.clientY - touch1.clientY
                        );
                        
                        if (this.touchDistance) {
                            const delta = newDistance / this.touchDistance;
                            this.zoom.scaleBy(this.svg, delta);
                            this.touchDistance = newDistance;
                        }
                    }
                }, { passive: true });

                // Touch end handler
                container.addEventListener('touchend', () => {
                    this.touchState.isDragging = false;
                    this.touchDistance = null;
                }, { passive: true });

                // Touch cancel handler
                container.addEventListener('touchcancel', () => {
                    this.touchState.isDragging = false;
                    this.touchDistance = null;
                }, { passive: true });
            }

            updateDimensions() {
                const container = this.container.node();
                const computedStyle = getComputedStyle(document.documentElement);
                const topSpacing = parseFloat(computedStyle.getPropertyValue('--spacing-top'));
                
                this.width = container.clientWidth - CONFIG.margin.left - CONFIG.margin.right;
                this.height = container.clientHeight - CONFIG.margin.top - CONFIG.margin.bottom - topSpacing;
            }

            initializeResizeHandler() {
                window.addEventListener('resize', () => {
                    this.updateDimensions();
                    this.svg
                        .attr("width", this.width + CONFIG.margin.left + CONFIG.margin.right)
                        .attr("height", this.height + CONFIG.margin.top + CONFIG.margin.bottom);
                    
                    this.tree.size([this.width, this.height]);
                    this.update(this.root);
                });
            }

            setupControls() {
                const zoomIn = document.getElementById('zoomIn');
                const zoomOut = document.getElementById('zoomOut');
                const reset = document.getElementById('reset');
                
                zoomIn.addEventListener('click', () => this.zoom.scaleBy(this.svg.transition().duration(300), 1.2));
                zoomOut.addEventListener('click', () => this.zoom.scaleBy(this.svg.transition().duration(300), 0.8));
                reset.addEventListener('click', () => {
                    this.svg.transition().duration(300).call(
                        this.zoom.transform,
                        d3.zoomIdentity.translate(CONFIG.margin.left, CONFIG.margin.top + this.initialVerticalOffset)
                    );
                });
            }
        
            /**
             * Sets up the SVG container and adds basic structural elements
             * Includes a border and transformation group for zooming
             * @private
            */
            initializeSVG() {
                // Create main SVG container with specified dimensions
                this.svg = this.container.append("svg")
                    .attr("width", this.width + CONFIG.margin.left + CONFIG.margin.right)
                    .attr("height", this.height + CONFIG.margin.top + CONFIG.margin.bottom)
                    .style("display", "block")
                    .style("margin", "auto");
        
                // Create group for zoom transformations with adjusted initial transform
                this.zoomGroup = this.svg.append("g")
                    .attr("transform", `translate(\${CONFIG.margin.left},\${CONFIG.margin.top + parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--spacing-top'))})`);
            }
        
            /**
             * Adds a dashed border around the visualization
             * @private
            */
            addBorder() {
                this.svg.append("rect")
                    .attr("width", this.svg.attr("width"))
                    .attr("height", this.svg.attr("height"))
                    .attr("fill", "none")
                    .attr("stroke", CONFIG.linkStyle.strokeColor)
                    .attr("stroke-width", CONFIG.linkStyle.strokeWidth)
                    .attr("stroke-dasharray", "5,5");
            }
        
            /**
             * Initializes zoom behavior with scale limits and event handling
             * @private
            */
            setupZoom() {
                this.zoom = d3.zoom()
                    .scaleExtent([0.3, 3])
                    .on("zoom", ({ transform }) => {
                        this.zoomGroup.attr("transform", transform);
                    });

                const initialTransform = d3.zoomIdentity
                    .translate(CONFIG.margin.left, CONFIG.margin.top + this.initialVerticalOffset);

                this.svg.call(this.zoom)
                    .call(this.zoom.transform, initialTransform);
            }
        
            /**
             * Sets up the initial tree structure and collapses all nodes
             * @param {TreeNode} data - Root node of the tree
             * @private
            */
            initializeTree(data) {
                // Create D3 tree layout with adjusted size
                this.tree = d3.tree().size([this.width, this.height - this.initialVerticalOffset]);
        
                // Create hierarchy from data
                this.root = d3.hierarchy(data, d => d.children);
        
                // Set initial position with offset
                this.root.x0 = this.width / 2;
                this.root.y0 = this.initialVerticalOffset; // Start below the border
        
                // Collapse all nodes initially
                if (this.root.children) {
                    this.root.children.forEach(this.collapse);
                }
        
                this.update(this.root);
            }
        
            /**
             * Recursively collapses all children of a node
             * @param {d3.HierarchyNode} node - Node to collapse
             * @private
            */
            collapse = (node) => {
                if (node.children) {
                    node._children = node.children;  // Store children in _children
                    node._children.forEach(this.collapse);
                    node.children = null;  // Remove children to collapse
                }
            }
        
            /**
             * Generates SVG path data for connecting lines between nodes
             * Uses curved lines with control points
             * @param {Object} source - Starting point coordinates
             * @param {Object} target - Ending point coordinates
             * @returns {string} SVG path data
             * @private
            */
            diagonal(source, target) {
                return `M \${source.x} \${source.y}
                        C \${source.x} \${(source.y + target.y) / 2},
                        \${target.x} \${(source.y + target.y) / 2},
                        \${target.x} \${target.y}`;
            }
        
            /**
             * Updates the visualization when node states change
             * Handles node positions, transitions, and link updates
             * @param {d3.HierarchyNode} source - Node that triggered the update
             * @public
            */
            update(source) {
                const treeData = this.tree(this.root);
                const nodes = treeData.descendants();
                const links = treeData.descendants().slice(1);
        
                // Normalize for fixed-depth
                nodes.forEach(node => {
                    node.y = node.depth * 120;  // Vertical spacing between levels
                });
        
                this.updateNodes(nodes, source);
                this.updateLinks(links, source);
        
                // Store the old positions for transitions
                nodes.forEach(node => {
                    node.x0 = node.x;
                    node.y0 = node.y;
                });
            }
        
            /**
             * Handles the enter/update/exit cycle for nodes
             * @param {d3.HierarchyNode[]} nodes - Array of tree nodes
             * @param {d3.HierarchyNode} source - Source node for transitions
             * @private
            */
            updateNodes(nodes, source) {
                const node = this.zoomGroup.selectAll("g.node")
                    .data(nodes, d => d.id || (d.id = ++this.i));
        
                const nodeEnter = this.createNodes(node, source);
                this.updateExistingNodes(nodeEnter, node);
                this.removeNodes(node, source);
            }
        
            /**
             * Creates new nodes in the visualization
             * @param {d3.Selection} node - D3 selection of nodes
             * @param {d3.HierarchyNode} source - Source node for transitions
             * @returns {d3.Selection} New node elements
             * @private
            */
            createNodes(node, source) {
                const nodeEnter = node.enter().append("g")
                    .attr("class", "node")
                    .attr("transform", () => `translate(\${source.x0},\${source.y0})`)
                    .on("click", (_event, d) => this.handleClick(d))
                    .on("mouseover", (_event, d) => this.handleMouseOver(d))
                    .on("mousemove", (event) => this.handleMouseMove(event))
                    .on("mouseout", () => this.handleMouseOut());
        
                // Add circles for nodes
                nodeEnter.append("circle")
                    .attr("class", "node")
                    .attr("r", 1e-6)
                    .style("fill", d => d._children ? "lightsteelblue" : "#fff");
        
                // Add labels for nodes
                nodeEnter.append("text")
                    .attr("dy", ".35em")
                    .attr("x", d => d.children || d._children ? -13 : 13)
                    .attr("text-anchor", d => d.children || d._children ? "end" : "start")
                    .text(d => d.data.username);
        
                return nodeEnter;
            }
        
            /**
             * Updates existing nodes with new positions and states
             * @param {d3.Selection} nodeEnter - Enter selection of new nodes
             * @param {d3.Selection} node - Update selection of existing nodes
             * @private
            */
            updateExistingNodes(nodeEnter, node) {
                const nodeUpdate = nodeEnter.merge(node);
        
                // Transition nodes to their new positions
                nodeUpdate.transition()
                    .duration(CONFIG.transitionDuration)
                    .attr("transform", d => `translate(\${d.x},\${d.y})`);
        
                nodeUpdate.select("circle.node")
                    .attr("r", CONFIG.nodeRadius)
                    .style("fill", d => d._children ? "lightsteelblue" : "#fff")
                    .attr("cursor", "pointer");
            }
        
            /**
             * Handles the removal of nodes from the visualization
             * @param {d3.Selection} node - D3 selection of nodes to remove
             * @param {d3.HierarchyNode} source - Source node for transitions
             * @private
            */
            removeNodes(node, source) {
                const nodeExit = node.exit().transition()
                    .duration(CONFIG.transitionDuration)
                    .attr("transform", () => `translate(\${source.x},\${source.y})`)
                    .remove();
        
                nodeExit.select("circle")
                    .attr("r", 1e-6);
        
                nodeExit.select("text")
                    .style("fill-opacity", 1e-6);
            }
        
            /**
             * Updates the connecting lines between nodes
             * @param {d3.HierarchyNode[]} links - Array of links between nodes
             * @param {d3.HierarchyNode} source - Source node for transitions
             * @private
            */
            updateLinks(links, source) {
                const link = this.zoomGroup.selectAll("path.link")
                    .data(links, d => d.id);
        
                // Enter any new links at the parent's previous position
                const linkEnter = link.enter().insert("path", "g")
                    .attr("class", "link")
                    .attr("d", () => {
                        const o = { x: source.x0, y: source.y0 };
                        return this.diagonal(o, o);
                    });
        
                // Transition links to their new position
                linkEnter.merge(link)
                    .transition()
                    .duration(CONFIG.transitionDuration)
                    .attr("d", d => this.diagonal(d, d.parent));
        
                // Remove any exiting links
                link.exit().transition()
                    .duration(CONFIG.transitionDuration)
                    .attr("d", () => {
                        const o = { x: source.x, y: source.y };
                        return this.diagonal(o, o);
                    })
                    .remove();
            }
        
            /**
             * Handles click events on nodes to toggle expansion/collapse
             * @param {d3.HierarchyNode} node - Clicked node
             * @private
            */
            handleClick(node) {
                if (node.children) {
                    node._children = node.children;
                    node.children = null;
                } else {
                    node.children = node._children;
                    node._children = null;
                }
        
                this.update(node);
            }
        
            /**
             * Shows tooltip with node details on mouseover/touch
             * @param {d3.HierarchyNode} node - Node being interacted with
             * @private
             */
            handleMouseOver(node) {
                if (this.tooltipTimeout) {
                    clearTimeout(this.tooltipTimeout);
                }
                
                // Check if we're not currently dragging on mobile
                if (!this.touchState.isDragging) {
                    this.tooltip
                        .style("opacity", "1")
                        .html(this.generateTooltipContent(node.data.details));
                }
            }

            {$tooltipContent}
        
            /**
             * Updates tooltip position on mouse movement
             * @param {MouseEvent} event - Mouse move event
             * @private
             */
            handleMouseMove(event) {
                const isMobile = window.innerWidth <= 768;
                if (!isMobile && !this.touchState.isDragging) {
                    const tooltipWidth = this.tooltip.node().offsetWidth;
                    const tooltipHeight = this.tooltip.node().offsetHeight;
                    
                    let left = event.pageX + 15;
                    let top = event.pageY - tooltipHeight - 10;
                    
                    if (left + tooltipWidth > window.innerWidth) {
                        left = event.pageX - tooltipWidth - 15;
                    }
                    
                    if (top < 0) {
                        top = event.pageY + 20;
                    }
                    
                    this.tooltip
                        .style("left", `\${left}px`)
                        .style("top", `\${top}px`);
                }
            }
        
            /**
             * Hides tooltip when mouse leaves a node
             * @private
             */
            handleMouseOut() {
                // Add a small delay before hiding tooltip
                this.tooltipTimeout = setTimeout(() => {
                    this.tooltip.style("opacity", "0");
                }, 100);
            }
        }
    JS;

    $str .= ajax($type, $user_id, $plan);

    return $str;
}

/**
 * Generates the JavaScript code for the tooltip content based on the plan type.
 *
 * This function dynamically generates the `generateTooltipContent` method for the
 * `TreeVisualization` class. The tooltip content is customized based on the attributes
 * associated with the given plan type.
 *
 * @param string $plan The plan type (e.g., 'binary_pair', 'unilevel').
 *
 * @return string The JavaScript code for the `generateTooltipContent` method.
 */
function tooltipContent($plan): string
{
    // Get the attributes for the plan
    $attributes = set_attr($plan);

    // Generate the tooltip content based on the attributes
    if (is_array($attributes)) {
        // Handle multiple attributes
        $attrList = implode(', ', $attributes);

        $tooltipContent = <<<JS
            /**
             * Generates HTML content for the tooltip
             * @param {Object} details - Node details object
             * @returns {string} HTML content for tooltip
             * @private
             */
            generateTooltipContent(details) {
                const { username, account, balance, {$attrList} } = details;
            
                return `
                    <div><strong>User:</strong> \${username}</div>
                    <div><strong>Account:</strong> \${account}</div>
                    <div><strong>Balance:</strong> \${balance}</div>
                    <div><strong>Income:</strong> \${{$attributes[0]}}</div>
                    <div><strong>Status:</strong> \${{$attributes[1]}}</div>
                `;
            }
        JS;
    } else {
        // Handle single attribute
        $tooltipContent = <<<JS
            /**
             * Generates HTML content for the tooltip
             * @param {Object} details - Node details object
             * @returns {string} HTML content for tooltip
             * @private
             */
            generateTooltipContent(details) {
                const { username, account, balance, plan, {$attributes} } = details;
            
                return `
                    <div><strong>User:</strong> \${username}</div>
                    <div><strong>Account:</strong> \${account}</div>
                    <div><strong>Balance:</strong> \${balance}</div>
                    <div><strong>\${plan}:</strong> \${{$attributes}}</div>
                `;
            }
        JS;
    }

    return $tooltipContent;
}

/**
 * Retrieves the attributes associated with a given plan type.
 *
 * This function maps a plan type (e.g., 'binary_pair', 'unilevel') to its corresponding
 * attributes. These attributes are used to dynamically generate tooltip content in the
 * genealogy visualization.
 *
 * @param string $plan The plan type (e.g., 'binary_pair', 'unilevel').
 *
 * @return string|array The attribute(s) associated with the plan. Returns a string for
 *                      single attributes or an array for multiple attributes.
 */
function set_attr($plan)
{
    // Iterate through the plan attributes to find a match
    foreach (plan_attr() as $k => $v) {
        if ($k === $plan) {
            return $v; // Return the attribute(s) for the matching plan
        }
    }

    // Return a default attribute if no match is found
    return 'status';
}

/**
 * Defines the mapping of plan types to their associated attributes.
 *
 * This function returns an associative array where the keys are plan types (e.g., 'binary_pair',
 * 'unilevel') and the values are the attributes associated with each plan. These attributes are
 * used to dynamically generate tooltip content in the genealogy visualization.
 *
 * @return array An associative array mapping plan types to their attributes.
 */
function plan_attr(): array
{
    return [
        'indirect_referral' => 'bonus_indirect_referral',
        'unilevel' => 'unilevel',
        'echelon' => 'bonus_echelon',
        'binary_pair' => ['income_cycle', 'status'],
        'leadership_binary' => 'bonus_leadership',
        'leadership_passive' => 'bonus_leadership_passive',
        'matrix' => 'bonus_matrix',
        'power' => 'bonus_power',
        'matrix_table' => 'bonus_share',
        'harvest' => 'bonus_harvest'
    ];
}