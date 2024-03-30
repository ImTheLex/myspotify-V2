const clientId = 'e12406cdbc024ae29a2017fdfc6b7dcd';
const clientSecret = '0f7f555e8b0c4173990847533a85f8d3';
let dataToken


    export async function fetchAccessToken () {
      const r = await fetch('https://accounts.spotify.com/api/token', {

        method: "POST",

        headers: {

          "Accept":"application/json",
          "Content-Type":"application/x-www-form-urlencoded"
        },
        body:`grant_type=client_credentials&client_id=${clientId}&client_secret=${clientSecret}`


      })
    
      const data = await r.json()
      dataToken = data.access_token
    
      
    }

    await fetchAccessToken()

    
    export async function fetchSeveralArtistsData () {

      const severalArtistsResponse = await fetch('https://api.spotify.com/v1/artists?ids=2msPoIYdnKVeuOOM960FC2,02kJSzxNuaWGqwubyUba0Z,22tU9RAG5HZ9BatYWY66UH,47mIJdHORyRerp4os813jD,64M6ah0SkkRsnPGtGiRAbb,6FfjnGXMhxSsJTuGLWBDth,7dGJo4pcD2V6oG8kP0tJRR,2roV5f30gWneIOkPjdpntN,5pKCCKE2ajJHZ9KAiaK11H,1Yfe3ONJlioHys7jwHdfVm,5CCwRZC6euC8Odo6y9X8jr,7wjeXCtRND2ZdKfMJFu6JC,1Xyo4u8uXC1ZmMpatF05PJ,246dkjvS1zLTtiykXe5h60,1feoGrmmD8QmNqtK2Gdwy8', {

        method: "GET",

        headers: {
          "Authorization":`Bearer  ${dataToken}`,
        }

      })


      const severalArtistsData = await severalArtistsResponse.json()
        // console.log(`API data of Several Artists: `, severalArtistsData)

        return severalArtistsData

    }


    export async function fetchSeveralTracksData () {

      const severalTracksResponse = await fetch ('https://api.spotify.com/v1/tracks?ids=5k38wzpLb15YgncyWdTZE4,3nh5RSXnRSHWuQbOJvQr0g,40YcuQysJ0KlGQTeGUosTC,1v7L65Lzy0j0vdpRjJewt1,5It9sRLGfnqFeroVSy1ebc,4szdK6sb0M8rFqd7AroyXm,3jevgr3fYdv9wYO3IDJq2a,5MtzlELTZJtuXzFZGtUeun,2ExKb6Ag2WXob6FpkSeXhE,60jzFy6Nn4M0iD1d94oteF,6RHdHHlOAHwFaYS9LUwpYU,23L5CiUhw2jV1OIMwthR3S,4wqIXeDppYSMXaWsnTzpzT,0OI7AFifLSoGzpb8bdBLLV,6zAiRKvAMlXHxEtyO4yxIO,4otT81iBBpaf36roGtzT4a,71vsEyBd4X1D5BUmLdFSVH,7culxZiBjN3w3yXqxgKIpD,6KI1ZpZWYAJLvmVhCJz65G,7jOvEsDIjHRH0LwCkwZSHS,75ZvA4QfFiZvzhj2xkaWAh,6AYs0tPiSYKh18DIwqBLQY,6AoBSeZg9YYt1GKtfcMGkY', {

      method: "GET",

      headers: {"Authorization":`Bearer  ${dataToken}`}

    })


    const severalTracksData = await severalTracksResponse.json()
    console.log(severalTracksData)
    
      return severalTracksData

    }

    export async function fetchUsersProfile () {

      const usersProfileResponse = await fetch('https://api.spotify.com/v1/users/31q3vzay4uslggey2gs3i7rq34za', {

      method: "GET",
      
      headers: {"Authorization":`Bearer  ${dataToken}`}

      })

      const usersProfileData = await usersProfileResponse.json()

      return usersProfileData
    }
  



      



    