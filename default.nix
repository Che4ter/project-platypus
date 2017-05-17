let
    pkgs = import <nixpkgs> {};
    stdenv = pkgs.stdenv;
    phpIni = pkgs.runCommand "php.ini"
    { options = ''
            zend_extension=${pkgs.php70Packages.xdebug}/lib/php/extensions/xdebug.so
            max_execution_time = 0
            xdebug.remote_autostart=on
            xdebug.remote_enable=on
            xdebug.remote_mode=req
            xdebug.remote_handler=dbgp
            xdebug.remote_host=localhost
            xdebug.remote_port=9000
      '';
    }
    ''
      cat "${pkgs.php70}/etc/php.ini" > $out
      echo "$options" >> $out
    '';

    # make an own version of php with the new php.ini from above
    # add all extensions needed as buildInputs and don't forget to load them in the php.ini above
    phpOverride = stdenv.mkDerivation rec {
        name = "php-with-xdebug-phpini";
        buildInputs = [pkgs.php70 pkgs.php70Packages.xdebug pkgs.makeWrapper];
        buildCommand = ''
          makeWrapper ${pkgs.php70}/bin/php $out/bin/php --add-flags -c --add-flags "${phpIni}"
        '';
    };
in rec {
    phpXdebug = stdenv.mkDerivation rec {
        name = "phpxdebug-env";
        buildInputs = [phpOverride pkgs.php70Packages.composer pkgs.curl pkgs.jq pkgs.bash pkgs.mariadb];
    };
}
