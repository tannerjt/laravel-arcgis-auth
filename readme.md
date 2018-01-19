# ArcGIS Sign In for Laravel

This is an example of using [ArcGIS Online's OAuth 2.0 ](https://developers.arcgis.com/documentation/core-concepts/security-and-authentication/) authentication protocol for logging into an external application.  Once authenticated (using the [ArcGIS Socialite Provider](http://socialiteproviders.github.io/providers/arcgis/)), a new user is created in the database.

## Setup

You will first need to register your application with your ArcGIS Online Organization through [developers.arcgis.com](https://developers.arcgis.com/).  Once registered, you need to setup a callback URL for OAuth 2.0 to return the user information.  It should look like `http://<your url>/login/arcgis/callback`.  Keep note of your your `Client ID` and `Client Secret`, you will add these to your environment variables.

Next, rename the `.env.example` file to `.env` and fill out your database information and the `ARCGIS_*` information for your registered app.  For added security, also enter your `ARCGIS_ORG_ID`.

Once your application is registered and your `.env` file is completed, you can install your app dependencies with `composer update`.
