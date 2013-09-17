#include <unistd.h>
#include <signal.h>
#include <sys/param.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>

void init_daemon(void) {
    int pid;
    int i;
    
    if((pid=fork())>0)
		exit(0);//是父进程，结束父进程
	else if(pid<0)
		exit(1);//fork失败，退出

	//是第一子进程，后台继续执行
	setsid();//第一子进程成为新的会话组长合进程组长
	//并与控制终端分离
	
	if((pid=fork())>0)
		exit(0);//是第一子进程，结束第一子进程
	else if(pid<0)
		exit(1);//fork失败，退出
	
	//是第二子进程，继续
	//第二子进程不再是会话组长
	
	for(i=0;i<NOFILE;++i)//关闭打开的文件描述符
		close(i);
		
	chdir("/tmp");//改变工作目录到/tmp
	umask(0);//重设文件创建掩模
	return;
	
}


int main(int argc, char** argv) {
	pid_t pid;
	FILE *fp1;
	char str[10];
	init_daemon();
	pid = getpid();
	sprintf(str,"%d",pid);
	strcat(str,"\n");
	fp1 = fopen("daemonRun","w");
	fputs(str,fp1);
	fclose(fp1);
	execl("/bin/sh","sh","-c",argv[1],(char *)0);
	_exit(127);
}









