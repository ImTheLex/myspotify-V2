# Spotify 'Clone'

Alright so let me introduce one of my biggest project so far.

This site acts like spotify in some way.

# What is the purpose of this site ?

Well if nothing is broken (lol) basicly you can have a users/artists/admin hierarchy.

All of those "roles" need to go through the signup steps first in order to use the rest of the site.

Once users are logged in for the first time, they will be notified with a "recover-token" message.

They can save it somewhere for later in case they need a password reset.


## 1) Users can :

- Manage playlists:
    - Create using a "+" button.

    ![Create Button](/public/ressources/tutoriel_image/image_1.png)

    - Update by clicking on it, then look after an "edit" button.

    ![Edit playlist](/public/ressources/tutoriel_image/image_2.png)

    - Add music tracks, this requires that an Artist has published a music track.

    ![Add Track](/public/ressources/tutoriel_image/image_3.png)

    - Delete playlists.

    ![Delete Playlist](/public/ressources/tutoriel_image/image_4.png)

    - Subscribe and unsubscribe playlists.

- Manage their profile.

    - Update their account information as well as deleting it.s

    - Create an Artist profile look after on your "profile" 

    ![Create or Delete Artist](/public/ressources/tutoriel_image/image_5.png)

- Contact the "support" through the site.

    - The notification system also allow to interact with the administration so in case a user has a question, he can "submit" a ticket.
    - Only 1 ticket can be submited at a time by a user until its responded.


## 2) Artists can :

- Manage their artist profile

    - This includes adding tracks

    - And of course modifying the artist name and so on.


## Can I import datas ?

In the "tools" folder, you'll find several files designed to facilitate a smooth and functional installation of this project. The setup relies on a ".env" file for data connection. Please refer to the provided ".env.example" as a template to create your own ".env" file.


## Sources

Trello :

- https://trello.com/b/Jt9ucQf3/spotify

Figma :

- https://www.figma.com/design/PLHbcuAjIPrfwzauyTUxC2/MyLittleBigProject?node-id=35-190&t=exxS2U3lkUBDlh0n-0

FigJam :

- https://www.figma.com/board/Kdqm6WEQHasQ7AynwDWGlk/todos-trello?t=exxS2U3lkUBDlh0n-0

# What is wrong with the site ?

A lot I guess lol, to be honest 

Here's a resume of what doesn't work yet:

- Delete a Track
- Delete a Track Relation
- Add an Artist Relation
- Delete an Artist Relation
- FAQ pages
- Change password through your account (forgot password should work based on recover token)
- Responsive for contact and admin pages
- Some audio related functionnalities.

## Important note ##

In a matter of not overflowing github with my countless tests I "gitignored" the datas in those folders.
However they may not be pushed in case they are empty, if they are not on the repo, ensure that you create them before using the "csv"
![alt text](/public/ressources/tutoriel_image/image_5.png) 

# Why is it this way ?

Due to certain project restrictions, such as the inability use libraries or add-ons, some functionalities may be less than ideal.

For instance, audio cannot be played across different pages.

However, it was crucial that the site function independently of Javascript, I've done my best to ensure this is the case !