# Specialistuddannelse Webapp
Tets of Deployment

## Guidelines for using GitHub
There's two default branches, `master` and `development`.
The master branch is used for production ready build, and is the one the server pulls from, therefore all development should be in the `development` branch.

### New Feature
When developing a new feature, a branch should be created from `development`, and when the featuere is done, the branch should be merged with `development`.
The branch naming scheme is as follows:`feature/feature-name`
So, for example, if I'm developing a voting system to vote on profiles, I would create a branch called `feature/voting`.
Then I would develop everything in there with all the code for the voting system. In the feature branch should only be the code to that specific feature (along with the previous cloned code base from the `development` branch).
##### IT'S IMPORTANT TO MAKE COMMITS OFTEN WITH A SHORT DESCRIPTIVE COMMIT MESSAGE !!!

### Production
It's important that `development` branch is **NOT** merged with `master` branch until the `development` branch is fully tested and has been qualified for release. The server will take care of the deploying itself when a new release is pushed to `master`

### Issues
If any bugs, feature requests, etc. they should be created as an issue on GitHub, along with the correct label.
Other questions should be asked to Silas, only devlopment questions should be asked on GitHub in form of issues.

### Before starting

After installation change .env CACHE_DRIVER=file to CACHE_DRIVER=array
then

```sh
$ php artisan make:roles
```

application generate Roles and Permissions.


if you update npm dependencies, and datepicker in "Course Managing panel" doesn't work (multi selection date , removing elements).
Go to node_modules/vue-datepicker/vue-datepicker.vue  in line 655
and remove  
```sh
 this.selectedDays.$remove(ctime); 
```
 
 and  instead of him  add 
 ```sh
 this.selectedDays.splice(ctime,1);
 ```

This is problem library and i hope this is fix in future.
