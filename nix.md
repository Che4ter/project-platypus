# Set-Up Development Environment using nix

Nix is a new kind of package manager which allows managing *all* the dependencies of development projects for all programming languages which have nix packages. 

In the case of this projects it allows us to have the dependencies on composer and a php environment with xdebug enabled.

It runs on Linux & Mac OSX. Under Windows you could use the new [Windows Subsystem For Linux]( https://msdn.microsoft.com/en-us/commandline/wsl/install_guide) to use it. Read more on their website [Nix](https://nixos.org/nix/). Instructions on how to install it can be found on their [Download Page](https://nixos.org/nix/download.html) and in their [Manual](https://nixos.org/nix/manual#chap-quick-start).

# Set up direnv

This is not a must, but its a quite useful package available from nixpkgs (The Nix Package Collection). 

It makes your shell automatically source the `.envrc` file if you enter a directory. For security reasons before any file gets sources you need to explicitly allow it to be sources everytime it changes.

How that works later, first we need to install it:

Install it into your nix user environment using:

    $ nix-env -i direnv

Then you modify your profile file for your shell and 
add the following line to it (change the shell to the one you use (`bash`, `zsh`, `fish`)).


See the man page for more information: [direnv.1](https://direnv.net/#man/direnv.1)

Then change into the directory where you cloned this project and execute `direnv allow .` (After you've read the .envrc file of course).

The directive `use nix` will execute the nix-shell command automatically and bring all project dependencies into your PATH. Also some more PATH entries are made for executing the scripts from composer packages (Stuff in `vendor/*/bin`).

# Installing all the dependencies using nix

This will download all the required dependencies and add them to your PATH (including php, composer, xdebug).

    $ nix-shell

You'll land in a new shell with everything available.

Unfortunately `composer` integration into nix is missing. So you'll
need to run `composer install` afterwards to get the required packages from packagist.org.

