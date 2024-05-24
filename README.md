# Spotify 'Clone' #

Alright so let me introduce one of my biggest project so far.

This site acts like spotify in some way.

It might be obvious, but this site doesn't have real connection with Spotify.

Apart from fetching the "previews audios".



# What is the purpose of this site ? #

Well if nothing is broken (lol) basicly you can have a users/artists/admin hierarchy.

Every user can decide to create an artist page, once it is done, they can then add tracks from their "artist profile".

Tracks data can either come from a file upload, or from a url link (this seems to work only for spotify api so far).



# How to install it and what are the requirements ? #

When cloning the repo, you should have a folder called "tools" in this folder you'll find the main schematics for the database (spotify_release.sql)

Then if you want to add a few datas, you can import the csv files.

![alt text](/public/ressources/tutoriel_image/tuto_img_1.png)



## Env ##

In a matter of learning and practicing, I included my database credentials into a ".env" file.

This file is not included on the github, however, you will find a ".env.example" which contains the same variables as my .env

All you might need to do is to adapt the "DB_PASS" if you have any on your device.

![alt text](/public/ressources/tutoriel_image/tuto_img_2.png)


## Is there an order for the datas ? ##

If you wish to use the csv to import some datas, I would recommend to follow this order, just in case some foreign keys are causing trouble.

1. Users.csv
2. Artists.csv
3. Playlists.csv
4. Categories.csv
5. Tracks.csv
6. Playlist_users_relations.csv
7. Playlist_tracks_relations.csv
 


## Sources ##

Trello :

- https://trello.com/b/Jt9ucQf3/spotify

Figma :

- https://www.figma.com/design/PLHbcuAjIPrfwzauyTUxC2/MyLittleBigProject?node-id=35-190&t=exxS2U3lkUBDlh0n-0

FigJam :

- https://www.figma.com/board/Kdqm6WEQHasQ7AynwDWGlk/todos-trello?t=exxS2U3lkUBDlh0n-0


# What is wrong with the site ? #

A lot I guess lol, to be honest 

Here's a resume of what doesn't work yet:

- Delete a Track
- Delete a Track Relation
- Add an Artist Relation
- Delete an Artist Relation
- FAQ pages
- Change password through your account (forgot password should work based on recover token)
- Some audio related functionnalities
- "Remember me" when logging in
- Some "success" or "error" messages are not displayed
- Some playlist responsive is not well handled
 

# Why is it this way ? #

Due to certain project restrictions, such as the inability use libraries or add-ons, some functionalities may be less than ideal.

For instance, audio cannot be played across different pages.

However, it was crucial that the site function independently of Javascript, I've done my best to ensure this is the case !