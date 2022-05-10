# Add a module

Once you've added an activity, you can add modules to it to add functionality. A module is a step a user must take to complete the activity, such as uploading their constitution or confirming they've completed training. Step one is choosing the type of module you want to add.

> ![Select a Module](./../images/module-selection.png)
*Select the module type as the first step.*

You can then build up the module

> ![Create a Module](./../images/create-module.png)
*Add information about the module*

## Access, see and complete modules

There are three main settings to configure here. You should select the groups of people who

- Can see the module exists. This is useful for hiding modules from people who don't need to do it, such as if you had a module only for sports clubs.
- Are able to access the module. If you can't access the module you see it as greyed out, which is useful for if you can only complete a module once you've completed a previous one.
- Must complete the module. This will prevent the user from finishing the activity if they haven't finished this module.

If you can see the module but can't access it you'll see the module as 'locked'.

??? note "How do different settings look to a user?"
    | Can see the module | Can access the module | Must complete the module |                                                                    |
    |--------------------|-----------------------|--------------------------|--------------------------------------------------------------------|
    | Yes                | Yes                   | Yes                      | ![See, Access and Mandatory](./../images/see-access-mandatory.png) |
    | Yes                | Yes                   | No                       | ![See, Access and Optional](./../images/see-access-optional.png)   |
    | Yes                | No                    | Yes                      | ![See, Locked and Mandatory](./../images/see-locked-mandatory.png) |
    | Yes                | No                    | No                       | ![See, Locked and Optional](./../images/see-locked-optional.png)   |
    | No                 | Yes/No                | Yes/No                   | ![Can't see](./../images/hidden.png)                               |


## Module Settings

Each module will have settings to control how the page should work. These depend on the module type, so we've explained them in the 'Module' section.

## Module Permissions

You can control exactly who can do what on the page. Usually you should set this to the same as the 'audience' dropdown when creating the activity.

By setting a permission to 'No-one', the functionality will be removed. You can use this to take away the more complex functionality of modules such as being able to comment on a file.

The permissions listed are both for the admin and the student page, so you can control what staff can do in addition.
