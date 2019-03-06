|Attributes     |Tables                |Datatypes   |Description                  |
|---------------|:--------------------:|:----------:|----------------------------:|
|id             |ALL                   |INT         |Auto incrementing            |
|username       |Users                 |VARCHAR2    |Username for acct            |
|password       |Users                 |VARCHAR2    |Password for acct            |
|type           |Users                 |CHAR        |Type of acct (Admin/Mod/User)|
|page_id        |Changes               |INT         |Id of the affected page      |
|comment        |Changes               |VARCHAR2    |User comment requesting change|
|name           |Items, Enemies, Spells, Locations, Quartz|VARCHAR2|Name of the entry|
|location       |Items, Enemies        |VARCHAR2    |Location of the item/enemy   |
|description    |Items, Enemies, Spells, Locatios, Quarts|VARCHAR2| Description of the entry|
|attributes     |Items                 |VARCHAR2    |How the item affects the player|
|image          |Enemies, Locations    |not sure yet|Image of the entry           |
|fire_effctvnss |Enemies               |INT         |The effectiveness of fire attacks|
|water_effctvnss|Enemies               |INT         |The effectiveness of water attacks|
|wind_effctvnss |Enemies               |INT         |The effectiveness of wind attacks|
|earth_effctvnss|Enemies               |INT         |The effectiveness of earth attacks|
|space_effctvnss|Enemies               |INT         |The effectiveness of space attacks|
|mirge_effctvnss|Enemies               |INT         |The effectiveness of mirage attacks|
|soul_effctvnss |Enemies               |INT         |The effectiveness of soul attacks|
|item_dropped   |Enemies               |VARCHAR2    |The item(s) dropped by the enemy|
|Type           |Enemies               |CHAR        |Type of enemy (Boss, Wanted, Normal)|
|elemental_reqrm|Spells                |INT         |placeholder. this is for all the elements and their spell requirements|