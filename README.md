# qna-forum
Project repository for the Q&amp;A Forum.

Steps:
1. Fire up XAMPP and start Apache and MySQL modules.
2. Click "Explorer" in the sidebar.
3. Navigate into the 'htdocs' folder in the window that pops up.
4. Create a new forder named 'qna' inside it.
5. Copy the contents of this repository into the 'qna' folder.

Setting up the database:

6. Open your web browser and go to 'localhost/phpmyadmin'
7. On the left pane, click New.
8. On the 'Database Name' field, type "agora".
9. The collation field should be "utf8mb4_general_ci" by default. If not, select that.
10. Create the database.
11. Click on the newly created database.
12. Navigate to the 'Import' tab from the top navigation pane.
13. Click on 'Choose File' and upload the "agora.sql" file provided in this repository.
14. Do not make any other changes and click on 'Go'.

The import should be successfully completed with 23 queries executed.

After completing these steps, you will be able to access our Website at 'localhost/qna'

Feel free to create a new user and make posts, reply to them and engage in a virtual discussion with yourself to grasp the feel of the website.
It is intentionally left blank so you are able to test things out.

A user has been created for testing purposes and the details are below:

Login Email: admin@forum.site

Login Password (case sensitive): Administrator#1
