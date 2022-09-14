FROM jenkinsci/blueocean

USER root

ENV JAVA_OPTS -Djenkins.install.runSetupWizard=false

ENV CASC_JENKINS_CONFIG /usr/local/jenkins-casc.yaml

COPY plugins.txt /plugins.txt

RUN /usr/local/bin/install-plugins.sh < /plugins.txt

COPY jenkins-casc.yaml /usr/local/jenkins-casc.yaml

USER jenkins