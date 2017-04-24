SELECT tree_color.treeID, color.colorID, color.name
FROM tree_color
JOIN color on tree_color.colorID = color.colorID;