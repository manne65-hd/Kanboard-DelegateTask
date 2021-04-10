DelegateTask for kanboard
===================================

Allows project-viewers to delegate a task into the first column of the project ...
- by adding an appropriate button only on the first column of the board
- by adding a new menu-entry on the board's dropdown-menu
- I am aware, that this could _(partly)_ be achieved by setting up a custom role, but this is just my first working version, while I have a couple of additional features planned for the future
  - Disable some of the input-fields
    -  Enable to configure the fields that should be disabled _(on a per-project-basis ??)_
  - Enforce some predefined content to be added to the delegated task, such as:
    - Add a tag
    - Set a priority
    - etc.



Screenshots
-----------
#### New button ONLY on first column
![New Delegate Task-button](https://user-images.githubusercontent.com/48651533/114271538-22de1280-9a12-11eb-81de-b6fd14ef8dc4.png)

#### New button with mouseover-popup
![02-DelegateTaskButtonPopup](https://user-images.githubusercontent.com/48651533/114271593-76506080-9a12-11eb-988e-3638aeab3029.png)

#### New entry to Delegate Task in the board's dropdown-menu
![03-DelegateTaskDropdown](https://user-images.githubusercontent.com/48651533/114271616-908a3e80-9a12-11eb-9972-aa2aa71269a2.png)


## This is the second working BETA-Release
 - I have tested this on a couple of my local test-installations
 - I you are using other plugins that OVERWRITE the template *board/table_column.php* please contact me, so I can check compatibilty!
   - My ["SortBoardByDates"-plugin](https://github.com/manne65-hd/Kanboard-SortBoardByDates) is already compatible!
 - MIGHT STILL CONTAIN BUGS


Author
------

- Manfred Hoffmann
- License MIT

Requirements
------------

- Kanboard >= 1.2.18

Installation
------------

You have the choice between 2 methods:

1. Download the zip file and decompress everything under the directory `plugins/DelegateTask`
2. Clone this repository into the folder `plugins/DelegateTask`

Note: Plugin folder is case-sensitive.
